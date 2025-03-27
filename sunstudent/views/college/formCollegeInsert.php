<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                <a href="?page=college" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Créer Collège</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du collège <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="nomCollege"
                                name="nomCollege"
                                class="form-control <?= isset($messages['nomCollege']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le nom du collège."
                                value="<?= htmlspecialchars($nomCollege ?? '') ?>">
                            <?php if (isset($messages["nomCollege"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["nomCollege"]) ?>
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
                            <button type='submit' name='insert' class='btn btn-success'>Créer</button>
                            <button type="reset" class="btn btn-danger">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>