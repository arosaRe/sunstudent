<?php
if (isset($_POST['confirmDelete'])) {
    $idUtilisateur = filter_input(INPUT_POST, 'idUtilisateur', FILTER_SANITIZE_NUMBER_INT);
    if ($modelUtilisateur->delete(['idUtilisateur' => $idUtilisateur])) {
        $router->redirectTo("user");
    }
}
?>