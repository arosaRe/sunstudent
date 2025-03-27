<main class="container mt-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Collège</h1>
        <?php if ($_SESSION["role"] != "professeur"): ?>
            <form action="#" method="post">
                <input type="submit" name="csv" value="CSV">
            </form>
        <?php endif; ?>
        <input type="text" name="searchBar" id="searchBar" placeholder="rechercher...">
        <a href="?page=formCollegeInsert" class="btn btn-success btn-sm">Ajouter un collège</a>
    </div>

    <!-- Table -->
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nom du Collège</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listeColleges[0])): ?>
                    <?php foreach ($listeColleges as $infoCollege): ?>
                        <tr>
                            <td><?= $infoCollege['nomCollege'] ?></td>
                            <td>
                                <form method='POST' action='?page=formCollegeUpdate' class='d-inline-block'>
                                    <input type='hidden' name='idCollege' value=<?= $infoCollege['idCollege'] ?>>
                                    <button class='btn btn-primary btn-sm me-1' type='submit'>Modifier</button>
                                </form>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' data-id='<?= $infoCollege['idCollege'] ?>'>Supprimer</button>
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
                    <p>Êtes-vous sûr de vouloir supprimer ce collège ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="?page=deleteCollege">
                        <input type="hidden" name="idCollege" id="idCollege">
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
        var idCollege = button.getAttribute('data-id');

        // Met à jour le champ caché de l'ID dans le formulaire
        var modalInput = confirmModal.querySelector('input[name="idCollege"]');
        modalInput.value = idCollege;
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