<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="?page=pays" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Créer Pays</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="form-control <?= isset($messages['nomPays']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le nom du pays"
                                value="<?= htmlspecialchars($nomPays ?? '') ?>">
                            <?php if (isset($messages["nomPays"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["nomPays"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Position -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                            <select
                                id="position"
                                name="position"
                                class="form-select <?= isset($messages['position']) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled <?= !isset($position) || !$position ? 'selected' : ''; ?>>Sélectionnez la position</option>
                                <option value="Etat Membre" <?= isset($position) && $position == "Etat Membre" ? "selected" : ''; ?>>Etat Membre</option>
                                <option value="Etat Observateur" <?= isset($position) && $position == "Etat Observateur" ? "selected" : ''; ?>>Etat Observateur</option>
                            </select>
                            <?php if (isset($messages["position"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["position"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Collège -->
                        <div class="mb-3">
                            <label for="college" class="form-label">Collège <span class="text-danger">*</span></label>
                            <select
                                id="college"
                                name="college"
                                class="form-select <?= isset($messages['college']) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled <?= !isset($idCollege) || !$idCollege ? 'selected' : ''; ?>>Sélectionnez le collège</option>
                                <?php if (!empty($listeColleges[0])): ?>
                                    <?php foreach ($listeColleges as $infoCollege): ?>
                                        <option value='<?= $infoCollege['idCollege'] ?>' <?= isset($idCollege) && $idCollege == $infoCollege['idCollege'] ? 'selected' : '' ?>><?= $infoCollege['nomCollege'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (isset($messages["college"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["college"]) ?>
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