<!-- Deuxième barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <div class="container-fluid">
        <!-- Bouton menu mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($_SESSION["role"] != "professeur"): ?>
                    <li class="nav-item text-center mx-3">
                        <a class="nav-link" href="?page=pays">
                            <i class="bi bi-globe fs-3 mb-2"></i>
                            <div>Pays</div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-3">
                        <a class="nav-link" href="?page=college">
                            <i class="bi bi-building fs-3 mb-2"></i>
                            <div>Collège</div>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item text-center mx-3">
                    <a class="nav-link" href="?page=etudiant">
                        <i class="bi bi-person fs-3 mb-2"></i>
                        <div>Étudiant</div>
                    </a>
                </li>
                <li class="nav-item text-center mx-3">
                    <a class="nav-link" href="?page=resolution">
                        <i class="bi bi-check-circle fs-3 mb-2"></i>
                        <div>Résolutions</div>
                    </a>
                </li>
                <?php if ($_SESSION["role"] != "professeur"): ?>
                    <li class="nav-item text-center mx-3">
                        <a class="nav-link" href="?page=theme">
                            <i class="bi bi-palette fs-3 mb-2"></i>
                            <div>Thème</div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-3">
                        <a class="nav-link" href="?page=user">
                            <i class="bi bi-person-circle fs-3 mb-2"></i>
                            <div>Utilisateur</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>