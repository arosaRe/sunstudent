<?php

$_SESSION = array();

session_destroy();

$router->redirectTo("connexion");