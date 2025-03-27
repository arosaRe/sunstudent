<main class="container mt-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Utilisateur</h1>
        <input type="text" name="searchBar" id="searchBar" placeholder="rechercher...">
        <a href="?page=formUserInsert" class="btn btn-success btn-sm">Ajouter un utilisateur</a>
        <?php if ($_SESSION['role'] === "super administrateur"): ?>
            <a href="?page=formUserInsertAdmin" class="btn btn-success btn-sm">Ajouter un administrateur</a>
        <?php endif; ?>
    </div>

    <!-- Table -->
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Email</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($listeUtilisateurs)):
                    foreach ($listeUtilisateurs as $infoUtilisateur):
                ?>
                        <tr>
                            <td><?= $infoUtilisateur['email'] ?></td>
                            <td><?= $infoUtilisateur['nomUtilisateur'] ?></td>
                            <td><?= $infoUtilisateur['prenomUtilisateur'] ?></td>
                            <td>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' data-id='<?= $infoUtilisateur['idUtilisateur'] ?>'>Supprimer</button>
                            </td>
                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
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
                    <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="?page=deleteUser">
                        <input type="hidden" name="idUtilisateur" id="idUtilisateur">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="confirmDelete" class="btn btn-danger">Supprimer</button>
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
        var idUtilisateur = button.getAttribute('data-id');

        // Met à jour le champ caché de l'ID dans le formulaire
        var modalInput = confirmModal.querySelector('input[name="idUtilisateur"]');
        modalInput.value = idUtilisateur;
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