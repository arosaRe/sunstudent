<?php
$messages = [];

// Vérification de l'envoi du formulaire
if (isset($_POST["connexion"])) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $motDePasse = filter_input(INPUT_POST, "motDePasse");


    // Validation des champs
    if (empty($email)) {
        $messages[] = "Le champ email est requis.";
    }
    if (empty($motDePasse)) {
        $messages[] = "Le champ Mot de passe est requis.";
    }
    $infoUtilisateur = $modelUtilisateur->select(["email" => $email]);
    // Si tout est valide, redirection vers la page d'accueil
    if (empty($messages)) {
        if ($infoUtilisateur && password_verify($motDePasse, $infoUtilisateur["motDePasse"])) {
            foreach ($infoUtilisateur as $champ => $valeur) {
                $_SESSION[$champ] = $valeur;
            }
            if ($infoCollegeUtilisateur = $modelCollegeUtilisateur->select(['idUtilisateur' => $infoUtilisateur['idUtilisateur']])) {
                $infoCollegeUtilisateur = !array_key_exists(0, $infoCollegeUtilisateur) ? [$infoCollegeUtilisateur] : $infoCollegeUtilisateur;
                $_SESSION['idCollege'] = [];
                foreach ($infoCollegeUtilisateur as $value) {
                    $_SESSION['idCollege'][] = $value['idCollege'];
                }
            }
            $router->redirectTo("accueil");
        } else {
            $messages[] = "Les identifiant ou le mot de passe sont faux !";
        }
    }
}
