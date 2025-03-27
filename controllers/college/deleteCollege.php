<?php
if (isset($_POST['confirmDelete'])) {
    $idCollege = filter_input(INPUT_POST, 'idCollege', FILTER_SANITIZE_NUMBER_INT);
    $college = $modelCollege->select(['idCollege' => $idCollege]);
    if ($modelCollege->delete(['idCollege' => $idCollege])) {
        $router->redirectTo("college");
    }
}
?>
