<?php
$messages = [];

// Vérification de l'envoi du formulaire
if (isset($_POST["change"])) {
    $mdp = filter_input(INPUT_POST, "mdp");
    $newMdp = filter_input(INPUT_POST, "newMdp");
    $confirmNewMdp = filter_input(INPUT_POST, "confirmNewMdp");


    // Validation des champs
    if (empty($mdp)) {
        $messages['mdp'] = "Le champ mot de passe est requis.";
    }
    if (empty($newMdp)) {
        $messages['newMdp'] = "Le champ nouveau mot de passe est requis.";
    }
    if (empty($confirmNewMdp)) {
        $messages['confirmNewMdp'] = "Le champ confirmer nouveau mot de passe est requis.";
    }

    $infoUtilisateur = $modelUtilisateur->select(["idUtilisateur" => $_SESSION['idUtilisateur']]);
    // Si tout est valide, redirection vers la page d'accueil
    if (empty($messages)) {
        if ($infoUtilisateur && password_verify($mdp, $infoUtilisateur["motDePasse"])) {
            if ($newMdp === $confirmNewMdp) {
                if ($newMdp != $mdp) {
                    $modelUtilisateur->update(["motDePasse" => password_hash($newMdp, PASSWORD_BCRYPT)], ["idUtilisateur" => $_SESSION['idUtilisateur']]);
                    $messages["success"] = "Vous avez changez de mot de passe !";
                }
                else {
                    $messages['newMdp'] = "Votre nouveau mot de passe et l'ancien sont les mêmes !";
                }
            }
            else {
                $messages['confirmNewMdp'] = "Les deux mot de passes ne sont pas identique !";
            }
        } else {
            $messages['mdp'] = "Le mot de passe est faux !";
        }
    }
}
