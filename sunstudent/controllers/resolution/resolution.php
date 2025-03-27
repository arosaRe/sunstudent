<?php

$roleUtilisateur = $_SESSION['role'] ?? '';  // Récupère le rôle depuis la session (par défaut vide si non défini)
$idUtilisateur = $_SESSION['idUtilisateur'] ?? '';

// Si l'utilisateur est professeur, on récupère uniquement les étudiants du même collège
if ($roleUtilisateur === 'professeur') {
    if ($modelResolution->select(['idUtilisateur' => $idUtilisateur])) {
        $listeResolutions = $modelResolution->select(['idUtilisateur' => $idUtilisateur]);
        $listeResolutions = !array_key_exists(0, $listeResolutions) ? [$listeResolutions] : $listeResolutions;
    }
} else {
    if ($modelResolution->select()) {
        $listeResolutions = $modelResolution->select();
        $listeResolutions = !array_key_exists(0, $listeResolutions) ? [$listeResolutions] : $listeResolutions;
    }
}
