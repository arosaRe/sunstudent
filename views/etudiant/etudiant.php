<main class="container mt-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Étudiants</h1>
        <?php if ($_SESSION["role"] != "professeur"): ?>
            <form action="#" method="post">
                <input type="submit" name="csv" value="CSV">
            </form>
        <?php endif; ?>
        <input type="text" name="searchBar" id="searchBar" placeholder="rechercher...">
        <a href="?page=formEtudiantInsert" class="btn btn-success btn-md">Ajouter un étudiant</a>
    </div>

    <!-- Table -->
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Pays</th>
                    <th>Date de naissance</th>

                    <!-- Si l'utilisateur est un administrateur, afficher la colonne Collège -->
                    <?php if ($_SESSION['role'] != 'professeur'): ?>
                        <th>Collège</th>
                    <?php endif; ?>

                    <th>Nom du Professeur</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listeEtudiants[0])): ?>
                    <?php foreach ($listeEtudiants as $etudiant): ?>
                        <?php
                        $infoPays = $modelPays->select(['idPays' => $etudiant['idPays']]);
                        $infoProfesseur = $modelUtilisateur->select(['idUtilisateur' => $etudiant['idProfesseur']]);
                        $infoCollege = $modelCollege->select(['idCollege' => $etudiant['idCollege']])
                        ?>
                        <tr>
                            <td><?= $etudiant['nomEtudiant'] ?></td>
                            <td><?= $etudiant['prenomEtudiant'] ?></td>
                            <td><?= $infoPays['nomPays'] ?></td>
                            <td><?= $etudiant['dateNaissance'] ?></td>
                            <?php if ($roleUtilisateur != 'professeur'): ?>
                                <td><?= $infoCollege['nomCollege'] ?></td>
                            <?php endif; ?>
                            <td><?= $infoProfesseur['nomUtilisateur'] ?> <?= $infoProfesseur['prenomUtilisateur'] ?></td>
                            <td>
                                <form method="POST" action="?page=formEtudiantUpdate" class="d-inline-block">
                                    <input type="hidden" name="idEtudiant" value="<?= $etudiant['idEtudiant'] ?>">
                                    <button class="btn btn-primary btn-sm me-1" type="submit">Modifier</button>
                                </form>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmModal" data-id="<?= $etudiant['idEtudiant'] ?>">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="?page=deleteEtudiant">
                        <input type="hidden" name="idEtudiant" id="idEtudiant">
                        <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="confirmDelete" class="btn btn-danger btn-md">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var confirmModal = document.getElementById('confirmModal');
    confirmModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Le bouton qui a déclenché la modale
        var idEtudiant = button.getAttribute('data-id'); // Récupère l'ID de l'étudiant

        // Met à jour le champ caché de l'ID dans le formulaire
        var modalInput = confirmModal.querySelector('input[name="idEtudiant"]');
        modalInput.value = idEtudiant;
    });
    document.getElementById("searchBar").addEventListener("input", function() {
        let filterValue = this.value.toLowerCase().replace(/\s/g, ""); // Minuscule + suppression espaces
        let rows = document.querySelectorAll("tbody tr");

        rows.forEach(row => {
            let cells = row.querySelectorAll("td");
            let match = false;

            cells.forEach(cell => {
                let cellValue = cell.textContent.toLowerCase().replace(/\s/g, ""); // Minuscule + suppression espaces
                if (cellValue.includes(filterValue)) {
                    match = true;
                }
            });

            // Affiche ou cache directement la ligne
            row.style.display = match ? "" : "none";
        });
    });
</script>