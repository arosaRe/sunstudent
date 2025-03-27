<?php
if (isset($_POST['confirmDelete'])) {
    $idPays = filter_input(INPUT_POST, 'idPays', FILTER_SANITIZE_NUMBER_INT);

    if ($modelPays->delete(["idPays" => $idPays])) {
        $router->redirectTo("pays");
    }
}
?>
