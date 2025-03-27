<!-- Première barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?page=accueil">STUDENT'S UNITED NATIONS</a>
        <div class="d-flex">
            <?php if ($_SESSION["role"] != "professeur"): ?>
                <a class="btn btn-outline-light me-2" href="?page=accueil">Accueil</a>
            <?php endif; ?>
            <a class="btn btn-outline-light me-2" href="?page=moncompte">Mon Compte</a>
            <a class="btn btn-outline-light" href="?page=deconnexion">Déconnexion</a>
        </div>
    </div>
</nav>