<?php
if ($modelCollege->select()) {
    $listeColleges = $modelCollege->select();
    $listeColleges = !array_key_exists(0, $listeColleges) ? [$listeColleges] : $listeColleges;
}
