<?php
// Fonction pour générer un nom de fichier unique
function genererNomFichier($extension)
{
    return uniqid('photo_', true) . '.' . $extension;
}

// Fonction pour valider et nettoyer les champs
function getSanitizedInput($field, $filter = null)
{
    if ($filter) {
        $input = filter_input(INPUT_POST, $field, $filter);
    } else {
        $input = filter_input(INPUT_POST, $field);
    }
    return $input !== null ? trim($input) : '';
}

// Fonction de validation des données
function validateEtudiantData($prenom, $nom, $dateNaissance, $idPays, $idProfesseur, $photo, $isAdmin, $modelCollegeUtilisateur, $idCollege = null)
{
    $messages = [];

    if (empty($prenom)) {
        $messages['prenom'] = "Veuillez remplir le champ prénom !";
    }
    if (empty($nom)) {
        $messages['nom'] = "Veuillez remplir le champ nom !";
    }
    if (empty($dateNaissance)) {
        $messages['dateNaissance'] = "Veuillez remplir la date de naissance !";
    } elseif (strtotime($dateNaissance) > time()) {
        $messages['dateNaissance'] = "La date saisie n'est pas valide !";
    }
    if (empty($idPays)) {
        $messages['pays'] = "Veuillez sélectionner un pays !";
    }
    if ($isAdmin && empty($idProfesseur)) {
        $messages['professeur'] = "Veuillez sélectionner un professeur !";
    } elseif ($idProfesseur) {
        $infoCollegeUtilisateur = $modelCollegeUtilisateur->select(["idUtilisateur" => $idProfesseur]);
        $infoCollegeUtilisateur = !array_key_exists(0, $infoCollegeUtilisateur) ? [$infoCollegeUtilisateur] : $infoCollegeUtilisateur;
        $found = false;

        foreach ($infoCollegeUtilisateur as $college) {
            if (isset($college['idCollege']) && $college['idCollege'] == $idCollege) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $messages['professeur'] = "Le professeur sélectionné n'appartient pas au collège du pays choisi !";
        }
    }

    if (empty($photo) && !is_uploaded_file($photo)) {
        $messages['photo'] = "Erreur lors du téléversement de la photo.";
    }

    return $messages;
}

// Initialisation des variables
$idEtudiant = $_SESSION['idEtudiant'] ?? null;
$photo = $_SESSION['photo'] ?? null;

$isAdmin = $_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'super administrateur';
$isProfesseur = $_SESSION['role'] === 'professeur';
$idCollegeProfesseur = $isProfesseur ? $_SESSION['idCollege'] : null;

$listePays = [];

if ($isProfesseur) {
    // Récupération des données en fonction du rôle
    foreach ($_SESSION["idCollege"] as $idCollege) {
        $pays = $modelPays->select(['idCollege' => $idCollege]);
        $listePays = array_merge($listePays, !array_key_exists(0, $pays) ? [$pays] : $pays);
    }
} else {
    $listePays = $modelPays->select();
}
$listePays = !array_key_exists(0, $listePays) ? [$listePays] : $listePays;
$listeProfesseurs = $isAdmin ? $modelUtilisateur->select(['role' => "professeur"]) : [];
$listeProfesseurs = !array_key_exists(0, $listeProfesseurs) ? [$listeProfesseurs] : $listeProfesseurs;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idEtudiant'])) {
        $idEtudiant = htmlspecialchars(getSanitizedInput('idEtudiant'));
        $_SESSION['idEtudiant'] = $idEtudiant;
        $infoEtudiant = $modelEtudiant->select(['idEtudiant' => $idEtudiant]);
        if ($infoEtudiant) {
            foreach ($infoEtudiant as $key => $value) {
                if ($key != "idEtudiant") {
                    ${$key} = $value;
                }
            }
        }
        $_SESSION['photo'] = $photo;
    }
    if (isset($_POST['update'])) {
        $prenomEtudiant = htmlspecialchars(getSanitizedInput('prenom'));
        $nomEtudiant = htmlspecialchars(getSanitizedInput('nom'));
        $dateNaissance = htmlspecialchars(getSanitizedInput('dateNaissance'));
        $idPays = htmlspecialchars(getSanitizedInput('pays'));
        $idProfesseur = $isAdmin ? filter_input(INPUT_POST, 'professeur', FILTER_SANITIZE_NUMBER_INT) : $_SESSION['idUtilisateur'];
        $photo = $_FILES['photo']['tmp_name'] == "" ? $photo : $_FILES['photo']['tmp_name'];

        $infoPays = $modelPays->select(['idPays' => $idPays]);

        $messages = validateEtudiantData($prenomEtudiant, $nomEtudiant, $dateNaissance, $idPays, $idProfesseur, $photo, $isAdmin, $modelCollegeUtilisateur, $infoPays['idCollege'] ?? null);
        if (empty($messages)) {
            if (isset($_POST['update'])) {
                $oldEtudiant = $modelEtudiant->select(['idEtudiant' => $idEtudiant]);
                $valueModify = array_filter([
                    'prenomEtudiant' => $prenomEtudiant !== $oldEtudiant['prenomEtudiant'] ? $prenomEtudiant : null,
                    'nomEtudiant' => $nomEtudiant !== $oldEtudiant['nomEtudiant'] ? $nomEtudiant : null,
                    'dateNaissance' => $dateNaissance !== $oldEtudiant['dateNaissance'] ? $dateNaissance : null,
                    'idPays' => $idPays != $oldEtudiant['idPays'] ? $idPays : null,
                    'idProfesseur' => $idProfesseur != $oldEtudiant['idProfesseur'] ? $idProfesseur : null,
                    'photo' => $photo !== $oldEtudiant['photo'] ? genererNomFichier(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)) : null,
                ]);

                if (!empty($valueModify)) {
                    if (!empty($valueModify['photo'])) {
                        move_uploaded_file($photo, "./photoEtudiant/" . $valueModify['photo']);
                        unlink("./photoEtudiant/" . $oldEtudiant['photo']);
                    }
                    $modelEtudiant->update($valueModify, ['idEtudiant' => $idEtudiant]);
                    $router->redirectTo("etudiant");
                }
                else {
                    unset($_SESSION['etudiant']);
                    $router->redirectTo("etudiant");
                }
            }
        }
    }
}
