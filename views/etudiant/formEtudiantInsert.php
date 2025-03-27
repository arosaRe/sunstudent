<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="?page=etudiant" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Nouvel Etudiant</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="form-control <?= isset($messages['nom']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez votre nom"
                                value="<?= htmlspecialchars($nomEtudiant ?? '') ?>">
                            <?php if (isset($messages["nom"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["nom"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Prénom -->
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                class="form-control <?= isset($messages['prenom']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez votre prénom"
                                value="<?= htmlspecialchars($prenomEtudiant ?? '') ?>">
                            <?php if (isset($messages["prenom"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["prenom"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Date de naissance -->
                        <div class="mb-3">
                            <label for="dateNaissance" class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input
                                type="date"
                                id="dateNaissance"
                                name="dateNaissance"
                                class="form-control <?= isset($messages['dateNaissance']) ? 'is-invalid' : ''; ?>"
                                value="<?= htmlspecialchars($dateNaissance ?? '') ?>">
                            <?php if (isset($messages["dateNaissance"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["dateNaissance"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Pays -->
                        <div class="mb-3">
                            <label for="pays" class="form-label">Pays <span class="text-danger">*</span></label>
                            <select
                                id="pays"
                                name="pays"
                                class="form-select <?= isset($messages['pays']) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled <?= !isset($idPays) || !$idPays ? 'selected' : ''; ?>>Sélectionnez votre pays</option>
                                <?php if (!empty($listePays[0])): ?>
                                    <?php foreach ($listePays as $infoPays): ?>
                                        <option value='<?= $infoPays['idPays'] ?>' <?= isset($idPays) && $idPays == $infoPays['idPays'] ? 'selected' : '' ?>><?= $infoPays['nomPays'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (isset($messages["pays"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["pays"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Champ Professeur -->
                        <?php if ($isAdmin): ?>
                            <div class="mb-3" id="divProfesseur">
                                <label for="professeur" class="form-label">Professeur <span class="text-danger">*</span></label>
                                <select id="professeur" name="professeur" class="form-select <?= isset($messages['professeur']) ? 'is-invalid' : ''; ?>">
                                    <option value="" disabled selected>Sélectionnez un professeur</option>
                                    <?php if (!empty($listeProfesseurs[0])): ?>
                                        <?php foreach ($listeProfesseurs as $infoProfesseur): ?>
                                            <option value='<?= $infoProfesseur['idUtilisateur'] ?>' <?= isset($idProfesseur) && $idProfesseur == $infoProfesseur['idUtilisateur'] ? 'selected' : '' ?>><?= $infoProfesseur['nomUtilisateur'] ?> <?= $infoProfesseur['prenomUtilisateur'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <?php if (isset($messages["professeur"])): ?>
                                    <div class="invalid-feedback">
                                        <?= htmlspecialchars($messages["professeur"]) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Champ Photo -->
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo <span class="text-danger">*</span></label>
                            <?php if (isset($photo) && $photo): ?>
                                <div class="mb-2">
                                    <img
                                        src="./photoEtudiant/<?= htmlspecialchars($photo) ?>"
                                        alt="photo"
                                        class="img-fluid rounded shadow-sm"
                                        style="object-fit: contain;">
                                </div>
                            <?php endif; ?>
                            <input
                                type="file"
                                id="photo"
                                name="photo"
                                class="form-control <?= isset($messages['photo']) ? 'is-invalid' : ''; ?>"
                                accept="image/*">
                            <div class="form-text">
                                Les photos sont demandées pour les badges. Par conséquent, veuillez s'il vous plaît faire en sorte que le visage soit clairement visible et prenne le maximum de place !
                            </div>
                            <?php if (isset($messages["photo"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["photo"]) ?>
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