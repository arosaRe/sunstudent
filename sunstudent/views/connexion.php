<main class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh; margin: 0;">
        <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h1 class="card-title text-center mb-4 text-primary">Connexion</h1>

                <!-- Affichage des messages d'erreur -->
                <?php if (!empty($messages)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($messages as $message): ?>
                                <li><?= $message; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre email" value="<?= isset($email) && $email ? $email : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" id="mdp" name="motDePasse" class="form-control" placeholder="Entrez votre mot de passe">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="connexion">Se connecter</button>
                </form>
            </div>
        </div>
    </main>