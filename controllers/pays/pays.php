<?php

if ($modelPays->select()) {
    $listePays = $modelPays->select();
    $listePays = !array_key_exists(0, $listePays) ? [$listePays] : $listePays;
}



