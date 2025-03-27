<main class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <div class="card-body text-center">
            <?php if ($_SESSION["role"] != "professeur"): ?>
                <!-- Formulaire pour les boutons -->
                <form action="#" method="post" class="mb-3">
                    <button type="submit" name="photo" class="btn btn-primary btn-lg w-100">Télécharger toutes les photos</button>
                </form>
                <form action="#" method="post">
                    <button type="submit" name="resolution" class="btn btn-primary btn-lg w-100">Télécharger toutes les résolutions</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>
