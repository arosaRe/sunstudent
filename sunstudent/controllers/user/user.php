<?php
if ($modelUtilisateur->select()) {
    $listeUtilisateurs = $modelUtilisateur->select();
    $listeUtilisateurs = !array_key_exists(0, $listeUtilisateurs) ? [$listeUtilisateurs] : $listeUtilisateurs;
}
