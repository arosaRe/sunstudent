<?php
$listeColleges = $modelCollege->select();
$listeColleges = !array_key_exists(0, $listeColleges) ? [$listeColleges] : $listeColleges;

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
function validateUtilisateurData($nomUtilisateur, $prenomUtilisateur, $motDePasse, $confirmMotDePasse, $modelUtilisateur, $email)
{
    $messages = [];
    if (empty($email)) {
        $messages['email'] = "Veuillez remplir le champ email !";
    }
    if (empty($nomUtilisateur)) {
        $messages['nomUtilisateur'] = "Veuillez remplir le champ nom !";
    }
    if (empty($prenomUtilisateur)) {
        $messages['prenomUtilisateur'] = "Veuillez remplir le champ prenom !";
    }
    if (empty($motDePasse)) {
        $messages['motDePasse'] = "Veuillez remplir le champ motDePasse !";
    }
    if (empty($confirmMotDePasse)) {
        $messages['confirmMotDePasse'] = "Veuillez remplir le champ confirmer mot de passe !";
    } else if ($confirmMotDePasse !== $motDePasse) {
        $messages['confirmMotDePasse'] = "Les deux mot de passe sont différent !";
    }
    if ($modelUtilisateur->select(["email" => $email])) {
        $messages['email'] = "Cette Utilisateur existe déjà !";
    }


    return $messages;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $nomUtilisateur = htmlspecialchars(getSanitizedInput('nomUtilisateur'));
        $prenomUtilisateur = htmlspecialchars(getSanitizedInput('prenomUtilisateur'));
        $motDePasse = htmlspecialchars(getSanitizedInput('motDePasse'));
        $confirmMotDePasse = htmlspecialchars(getSanitizedInput('confirmMotDePasse'));

        $messages = validateUtilisateurData($nomUtilisateur, $prenomUtilisateur, $motDePasse, $confirmMotDePasse, $modelUtilisateur, $email);
        if (empty($messages)) {
            if (isset($_POST['insert'])) {
                if ($lastId = $modelUtilisateur->insert([
                    'email' => $email,
                    'nomUtilisateur' => $nomUtilisateur,
                    'prenomUtilisateur' => $prenomUtilisateur,
                    'motDePasse' => password_hash($motDePasse, PASSWORD_BCRYPT),
                    'role' => "administrateur"
                ])){
                        $messages['success'] = "Vous avez créé l'administrateur $nomUtilisateur $prenomUtilisateur !";
                        $nomUtilisateur = $prenomUtilisateur = $motDePasse = $confirmMotDePasse = "";
                }
            }
        }
    }
}
