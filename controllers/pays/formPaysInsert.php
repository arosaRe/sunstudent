<?php
$listeColleges = $modelCollege->select();
$listeColleges = !array_key_exists(0, $listeColleges) ? [$listeColleges] : $listeColleges;

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
function validatePaysData($nomPays, $position, $idCollege, $modelPays)
{
    $messages = [];

    if ($modelPays->select(['nomPays' => $nomPays])) {
        $messages['nomPays'] = "Le pays $nomPays existe déjà !";
    }
    if (empty($nomPays)) {
        $messages['nomPays'] = "Veuillez remplir le champ pays !";
    }
    if (empty($position)) {
        $messages['position'] = "Veuillez choisir une position !";
    }
    if (empty($idCollege)) {
        $messages['college'] = "Veuillez choisir un collège !";
    }

    return $messages;
}

// Traitement de l'insertion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert'])) {
    $nomPays = htmlspecialchars(getSanitizedInput('nom'));
    $position = htmlspecialchars(getSanitizedInput('position'));
    $idCollege = filter_input(INPUT_POST, 'college', FILTER_SANITIZE_NUMBER_INT);

    $messages = validatePaysData($nomPays, $position, $idCollege, $modelPays);

    if (empty($messages)) {
        if ($modelPays->insert(['nomPays' => $nomPays, 'position' => $position, 'idCollege' => $idCollege])) {
            $messages['success'] = "Vous avez créé le pays $nomPays !";
            $nomPays = $position = "";
            $idCollege = 0;
        }
    }
}
