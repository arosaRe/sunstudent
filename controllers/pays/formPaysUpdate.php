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
function validatePaysData($nomPays, $position, $idCollege, $modelPays, $oldPays = null)
{
    $messages = [];

    if ($modelPays->select(['nomPays' => $nomPays]) && $nomPays !== $oldPays['nomPays']) {
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

$idPays = $_SESSION['idPays'] ?? null;

// Gestion des données de pays
if (isset($_POST['idPays'])) {
    $idPays = htmlspecialchars(getSanitizedInput('idPays'));
    $infoPays = $modelPays->select(['idPays' => $idPays]);
    $_SESSION['idPays'] = $idPays;
    if ($infoPays) {
        $nomPays = $infoPays['nomPays'] ?? "";
        $position = $infoPays['position'] ?? "";
        $idCollege = $infoPays['idCollege'] ?? 0;
    }
}

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nomPays = htmlspecialchars(getSanitizedInput('nom'));
    $position = htmlspecialchars(getSanitizedInput('position'));
    $idCollege = filter_input(INPUT_POST, 'college', FILTER_SANITIZE_NUMBER_INT);

    $oldPays = $modelPays->select(['idPays' => $idPays]);
    $valueModify = array_filter([
        'nomPays' => $nomPays !== $oldPays['nomPays'] ? $nomPays : null,
        'position' => $position !== $oldPays['position'] ? $position : null,
        'idCollege' => $idCollege != $oldPays['idCollege'] ? $idCollege : null
    ]);

    if (!empty($valueModify)) {
        $messages = validatePaysData($nomPays, $position, $idCollege, $modelPays, $oldPays);

        if (empty($messages)) {
            if ($modelPays->update($valueModify, ['idPays' => $idPays])) {
                unset($_SESSION['idPays']);
                $router->redirectTo("pays");
            }
        }
    } else {
        unset($_SESSION['idPays']);
        $router->redirectTo("pays");
    }
}

