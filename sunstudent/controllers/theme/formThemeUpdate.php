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

$idTheme = $_SESSION['idTheme'] ?? null;

// Gestion des données de pays
if (isset($_POST['idTheme'])) {
    $idTheme = htmlspecialchars(getSanitizedInput('idTheme'));
    $infoTheme = $modelTheme->select(['idTheme' => $idTheme]);
    $_SESSION['idTheme'] = $idTheme;
    if ($infoTheme) {
        $titre = $infoTheme['titre'] ?? "";
    }
}

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $titre = htmlspecialchars(getSanitizedInput('titre'));

    $oldTheme = $modelTheme->select(['idTheme' => $idTheme]);
    $valueModify = array_filter([
        'titre' => $titre !== $oldTheme['titre'] ? $titre : null,
    ]);

    if (!empty($valueModify)) {
        $messages = validateThemeData($titre, $modelTheme);

        if (empty($messages)) {
            if ($modelTheme->update($valueModify, ['idTheme' => $idTheme])) {
                unset($_SESSION['idTheme']);
                $router->redirectTo("theme");
            }
        }
    } else {
        unset($_SESSION['idTheme']);
        $router->redirectTo("theme");
    }
}