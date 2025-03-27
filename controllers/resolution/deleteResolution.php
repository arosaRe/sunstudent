<?php
if (isset($_POST['confirmDelete'])) {
    $idResolution = filter_input(INPUT_POST, 'idResolution', FILTER_SANITIZE_NUMBER_INT);
    $resolution = $modelResolution->select(['idResolution' => $idResolution]);
    if (unlink("./resolution/{$resolution['document']}") && $modelResolution->delete(['idResolution' => $idResolution])) {
        $router->redirectTo("resolution");
    }
}
?>