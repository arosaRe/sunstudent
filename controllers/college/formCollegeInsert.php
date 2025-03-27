<?php

// Fonction pour valider et nettoyer les champs
function getSanitizedInput($field, $filter = null)
{
    if ($filter) {
        $input = filter_input(INPUT_POST, $field, $filter);
    }else{
        $input = filter_input(INPUT_POST, $field);
    }
    return $input !== null ? trim($input) : '';
}

// Fonction de validation des données
function validateCollegeData($nomCollege, $modelCollege)
{
    $messages = [];

    if ($modelCollege->select(['nomCollege' => $nomCollege])) {
        $messages['nomCollege'] = "Le collège $nomCollege existe déjà !";
    }
    if (empty($nomCollege)) {
        $messages['nomCollege'] = "Veuillez remplir le champ nom !";
    }

    return $messages;
}

// Traitement de l'insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])) {
    $nomCollege = htmlspecialchars(getSanitizedInput('nomCollege'));

    $messages = validateCollegeData($nomCollege, $modelCollege);

    if (empty($messages)) {
        if ($modelCollege->insert(['nomCollege' => $nomCollege])) {
            $messages['success'] = "Vous avez créé le collège $nomCollege !";
        }
    }
}
