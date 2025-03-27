<?php
if (isset($_POST['confirmDelete'])) {
    $idEtudiant = filter_input(INPUT_POST, 'idEtudiant', FILTER_SANITIZE_NUMBER_INT);
    $etudiant = $modelEtudiant->select(['idEtudiant' => $idEtudiant]);
    if (unlink("./photoEtudiant/{$etudiant['photo']}") && $modelEtudiant->delete(['idEtudiant' => $idEtudiant])) {
        $router->redirectTo("etudiant");
    }
}
?>
