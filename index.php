<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 
require_once './controllers/router.php'; // Charger le routeur
global $router;
$router = Router::getInstance(); // Créer une instance du routeur
$router->handleRequest(); // Lancer la gestion de la requête
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SunStudent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column" style="height: 100vh; width: 100vw;">
    <?php if ($router->showNav()): ?>
        <?php require_once "./views/nav.php"; ?>
        <?php require_once "./views/underNav.php"; ?>
    <?php endif; ?>

    <!-- Contenu dynamique selon la page -->
    <?php $router->loadPage($router->getPage()); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
