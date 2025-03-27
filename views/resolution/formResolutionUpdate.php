<!-- Formulaire centré et responsive -->
<main class="container py-5" style="flex-grow: 1;">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="?page=resolution" class="btn btn-secondary btn-sm">Retour</a>
                    <h1 class="card-title text-center mb-4">Modifier Résolution</h1>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="sujet"
                                name="sujet"
                                class="form-control <?= isset($messages['sujet']) ? 'is-invalid' : ''; ?>"
                                placeholder="Entrez le sujet"
                                value="<?= htmlspecialchars($sujet ?? '') ?>">
                            <?php if (isset($messages["sujet"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["sujet"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="idTheme" class="form-label">Thème <span class="text-danger">*</span></label>
                            <select
                                id="idTheme"
                                name="idTheme"
                                class="form-select <?= isset($messages['idTheme']) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled <?= !isset($idTheme) || !$idTheme ? 'selected' : ''; ?>>Sélectionnez le thème</option>
                                <?php if (!empty($listeTheme[0])): ?>
                                    <?php foreach ($listeTheme as $infoTheme): ?>
                                        <option value='<?= $infoTheme['idTheme'] ?>' <?= isset($idTheme) && $idTheme == $infoTheme['idTheme'] ? 'selected' : '' ?>><?= $infoTheme['titre'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (isset($messages["idTheme"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["idTheme"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="idPays" class="form-label">Pays <span class="text-danger">*</span></label>
                            <select
                                id="idPays"
                                name="idPays"
                                class="form-select <?= isset($messages['idPays']) ? 'is-invalid' : ''; ?>">
                                <option value="" disabled <?= !isset($idPays) || !$idPays ? 'selected' : ''; ?>>Sélectionnez le pays</option>
                                <?php if (!empty($listePays[0])): ?>
                                    <?php foreach ($listePays as $infoPays): ?>
                                        <option value='<?= $infoPays['idPays'] ?>' <?= isset($idPays) && $idPays == $infoPays['idPays'] ? 'selected' : '' ?>><?= $infoPays['nomPays'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </select>
                            <?php if (isset($messages["idPays"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["idPays"]) ?>
                                </div>
                            <?php endif; ?>
                        </div>



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

                        <div class="mb-3">
                            <label for="resolution" class="form-label">Résolution <span class="text-danger">*</span></label>
                            <?php if (isset($document) && $document): ?>
                                <div style="position: relative; width: 100%; padding-top: 56.25%;">
                                    <iframe id="pdfViewer" src="./resolution/<?= htmlspecialchars($document) ?>"
                                        class="img-fluid rounded shadow-sm"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;">
                                    </iframe>
                                </div>
                            <?php endif; ?>
                            <input
                                type="file"
                                id="resolution"
                                name="resolution"
                                class="form-control <?= isset($messages['resolution']) ? 'is-invalid' : ''; ?>"
                                accept=".pdf,.doc,.docx,.txt">
                            <?php if (isset($messages["resolution"])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($messages["resolution"]) ?>
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