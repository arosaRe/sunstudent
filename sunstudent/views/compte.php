<main class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h1 class="card-title text-center mb-4 text-primary">Mon compte</h1>

            <!-- Formulaire -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" class="form-control <?= isset($messages['mdp']) ? 'is-invalid' : ''; ?>" placeholder="Entrez votre mot de passe">
                    <?php if (isset($messages["mdp"])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($messages["mdp"]) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="newMdp" class="form-label">Nouveau mot de passe</label>
                    <input type="password" id="newMdp" name="newMdp" class="form-control <?= isset($messages['newMdp']) ? 'is-invalid' : ''; ?>" placeholder="Entrez votre nouveau mot de passe">
                    <?php if (isset($messages["newMdp"])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($messages["newMdp"]) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="confirmNewMdp" class="form-label">Confirmer nouveau mot de passe</label>
                    <input type="password" id="confirmNewMdp" name="confirmNewMdp" class="form-control <?= isset($messages['confirmNewMdp']) ? 'is-invalid' : ''; ?>" placeholder="Confirmer votre nouveau mot de passe">
                    <?php if (isset($messages["confirmNewMdp"])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($messages["confirmNewMdp"]) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100" name="change">Changer de mot de passe</button>
                <?php if (isset($messages["success"])): ?>
                    <div class="alert alert-success mt-3">
                        <?= htmlspecialchars($messages["success"]) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</main>