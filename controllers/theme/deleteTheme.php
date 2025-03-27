<?php
if (isset($_POST['confirmDelete'])) {
    $idTheme = filter_input(INPUT_POST, 'idTheme', FILTER_SANITIZE_NUMBER_INT);
    if ($modelTheme->delete(['idTheme' => $idTheme])) {
        $router->redirectTo("theme");
    }
}
?>