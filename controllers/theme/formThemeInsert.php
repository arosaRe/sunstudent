<?php
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
function validateThemeData($titre, $modelTheme)
{
    $messages = [];
 
    if (empty($titre)) {
        $messages['titre'] = "Veuillez remplir le champ titre !";
    }
    elseif($modelTheme->select(["titre" => $titre])){
        $messages['titre'] = "Ce titre existe déjà !";
    }

    return $messages;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        $titre = htmlspecialchars(getSanitizedInput('titre'));

        $messages = validateThemeData($titre, $modelTheme);
        if (empty($messages)) {
            if (isset($_POST['insert'])) {
                if ($modelTheme->insert([
                    'titre' => $titre,
                ])) {
                    $messages['success'] = "Vous avez créé un thème !";
                    $titre = "";
                }
            }
        }
    }
}
