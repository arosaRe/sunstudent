<?php
// Vérification du rôle de l'utilisateur
$roleUtilisateur = $_SESSION['role'] ?? '';  // Récupère le rôle depuis la session (par défaut vide si non défini)

// Si l'utilisateur est professeur, on récupère uniquement les étudiants du même collège
if ($roleUtilisateur === 'professeur') {
    $listeEtudiants = [];
    foreach ($_SESSION["idCollege"] as $idCollege) {
        if ($modelEtudiant->select(['idCollege' => $idCollege])) {
            $etudiants = $modelEtudiant->select(['idCollege' => $idCollege]);
            $listeEtudiants = array_merge($listeEtudiants, !array_key_exists(0, $etudiants) ? [$etudiants] : $etudiants);
        }
    }
} else {
    if ($modelEtudiant->select()) {
        $listeEtudiants = $modelEtudiant->select();
        $listeEtudiants = !array_key_exists(0, $listeEtudiants) ? [$listeEtudiants] : $listeEtudiants;
    }
}
