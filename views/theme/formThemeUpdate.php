<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="?page=theme" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Modifier Thème</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="sujet" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="titre"
                                name="titre"
                                class="form-control <?= isset($messages['titre']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le titre"
                                value="<?= htmlspecialchars($titre ?? '') ?>">
                            <?php if (isset($messages["titre"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["titre"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Message de succès -->
                        <?php if (isset($messages["success"])): ?>
                            <div class="alert alert-success mt-3">
                                <?= htmlspecialchars($messages["success"]) ?>
                            </div>
                        <?php endif; ?>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <button type='submit' name='update' class='btn btn-success'>Modifier</button>
                            <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>