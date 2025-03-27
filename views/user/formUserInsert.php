<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="?page=user" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Créer Utilisateur</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control <?= isset($messages['email']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez l'email"
                                value="<?= htmlspecialchars($email ?? '') ?>">
                            <?php if (isset($messages["email"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["email"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="nomUtilisateur" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="nomUtilisateur"
                                name="nomUtilisateur"
                                class="form-control <?= isset($messages['nomUtilisateur']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le nom de l'utilisateur"
                                value="<?= htmlspecialchars($nomUtilisateur ?? '') ?>">
                            <?php if (isset($messages["nomUtilisateur"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["nomUtilisateur"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="prenomUtilisateur" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="prenomUtilisateur"
                                name="prenomUtilisateur"
                                class="form-control <?= isset($messages['prenomUtilisateur']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le prenom de l'utilisateur"
                                value="<?= htmlspecialchars($prenomUtilisateur ?? '') ?>">
                            <?php if (isset($messages["prenomUtilisateur"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["prenomUtilisateur"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="motDePasse" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input
                                type="password"
                                id="motDePasse"
                                name="motDePasse"
                                class="form-control <?= isset($messages['motDePasse']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le mot de passe de l'utilisateur">
                            <?php if (isset($messages["motDePasse"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["motDePasse"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirmMotDePasse" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <input
                                type="password"
                                id="confirmMotDePasse"
                                name="confirmMotDePasse"
                                class="form-control <?= isset($messages['confirmMotDePasse']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez à nouveau le mot de passe de l'utilisateur">
                            <?php if (isset($messages["confirmMotDePasse"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["confirmMotDePasse"]) ?>
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