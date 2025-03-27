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
function validateResolutionData($sujet, $idTheme,$idPays, $idProfesseur, $resolution, $isAdmin, $modelCollegeUtilisateur, $idCollege = null)
{
    $messages = [];

    if (empty($idPays)) {
        $messages['idPays'] = "Veuillez sélectionner un pays !";
    }
    if (empty($sujet)) {
        $messages['sujet'] = "Veuillez remplir le champ sujet !";
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
    if (empty($idTheme)) {
        $messages['idTheme'] = "Veuillez remplir le champ thème !";
    }

    if (empty($resolution) && !is_uploaded_file($resolution)) {
        $messages['resolution'] = "Erreur lors du téléversement de la résolution.";
    }

    return $messages;
}

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
$listeTheme = $modelTheme->select();
$listeTheme = !array_key_exists(0, $listeTheme) ? [$listeTheme] : $listeTheme;




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        $sujet = htmlspecialchars(getSanitizedInput('sujet'));
        $idTheme = htmlspecialchars(getSanitizedInput('idTheme'));
        $idPays = htmlspecialchars(getSanitizedInput('idPays'));
        $idProfesseur = $isAdmin ? filter_input(INPUT_POST, 'professeur', FILTER_SANITIZE_NUMBER_INT) : $_SESSION['idUtilisateur'];
        $document = $_FILES['resolution']['tmp_name'];

        $infoPays = $modelPays->select(['idPays' => $idPays]);

        $messages = validateResolutionData($sujet, $idTheme, $idPays, $idProfesseur, $document, $isAdmin, $modelCollegeUtilisateur, $infoPays['idCollege'] ?? null);
        if (empty($messages)) {
            if (isset($_POST['insert'])) {
                $documentName = "";
                if (!empty($document)) {
                    $documentName = genererNomFichier(pathinfo($_FILES['resolution']['name'], PATHINFO_EXTENSION));
                    move_uploaded_file($document, "./resolution/" . $documentName);
                }
                if ($modelResolution->insert([
                    'sujet' => $sujet,
                    'idTheme' => $idTheme,
                    'idPays' => $idPays,
                    'idUtilisateur' => $idProfesseur,
                    'document' => $documentName
                ])) {
                    $messages['success'] = "Vous avez créé une resolution !";
                    $sujet = $documentName = "";
                    $idProfesseur = $idPays = $idTheme = 0;
                }
            }
        }
    }
}
