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

$idCollege = $_SESSION['idCollege'] ?? null;

// Gestion des données de pays
if (isset($_POST['idCollege'])) {
    $idCollege = htmlspecialchars(getSanitizedInput('idCollege'));
    $infoCollege = $modelCollege->select(['idCollege' => $idCollege]);
    $_SESSION['idCollege'] = $idCollege;
    if ($infoCollege) {
        $nomCollege = $infoCollege['nomCollege'] ?? "";
    }
}

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nomCollege = htmlspecialchars(getSanitizedInput('nomCollege'));

    $oldCollege = $modelCollege->select(['idCollege' => $idCollege]);
    $valueModify = array_filter([
        'nomCollege' => $nomCollege !== $oldCollege['nomCollege'] ? $nomCollege : null,
    ]);

    if (!empty($valueModify)) {
        $messages = validateCollegeData($nomCollege, $modelCollege);

        if (empty($messages)) {
            if ($modelCollege->update($valueModify, ['idCollege' => $idCollege])) {
                unset($_SESSION['idCollege']);
                $router->redirectTo("college");
            }
        }
    } else {
        unset($_SESSION['idCollege']);
        $router->redirectTo("college");
    }
}

