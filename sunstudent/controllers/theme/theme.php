<?php
if ($modelTheme->select()) {
    $listeThemes = $modelTheme->select();
    $listeThemes = !array_key_exists(0, $listeThemes) ? [$listeThemes] : $listeThemes;
}
