<?php
require_once './models/db.php';
require_once './models/model.php';

class Router
{
    private static $instance = null;
    private $page;

    private function __construct()
    {
        $this->page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'accueil';
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    // Méthode pour gérer la demande de la page
    public function handleRequest()
    {
        session_start();
        if (isset($_POST["csv"])) {
            $this->convertToCSV();
        }
        if (isset($_POST['photo'])) {
            $this->downloadStudentPhotos();
        }
        if (isset($_POST['resolution'])) {
            $this->downloadStudentPDFs();
        }
        $this->checkAuthentication(); // Vérifie si l'utilisateur est connecté
    }

    // Fonction pour récupérer les fichiers PDF des étudiants
    function downloadStudentPDFs()
    {
        // Créer un dossier pour les PDF si ce n'est pas déjà fait
        $targetDir = 'downloads/resolution_pdfs/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Connexion à la base de données et récupération des fichiers PDF
        $model = new Model('resolution');
        $resolutions = $model->select();
        $resolutions = !array_key_exists(0, $resolutions) ? [$resolutions] : $resolutions;

        if ($resolutions[0] !== []) {
            // Créer un fichier ZIP pour stocker tous les fichiers PDF
            $zip = new ZipArchive();
            $zipFileName = 'downloads/resolution_pdfs.zip';

            if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
                die("Impossible de créer le fichier ZIP.");
            }

            // Télécharger chaque fichier PDF et l'ajouter au fichier ZIP
            foreach ($resolutions as $resolution) {
                $pdfName = $resolution['document']; // Assure-toi que la colonne 'resolution' contient le nom du fichier PDF
                $pdfUrl = './resolution/'; // Le chemin vers le répertoire où les PDFs sont stockés

                $modelPays = new Model('pays');
                $pays = $modelPays->select(['idPays' => $resolution['idPays']]);

                $modelUtilisateur = new Model('utilisateur');
                $utilisateur = $modelUtilisateur->select(['idUtilisateur' => $resolution['idUtilisateur']]);


                // Crée un nom unique pour le PDF (nom + prénom de l'étudiant)
                $newPdfName = $resolution['sujet'] . $pays['nomPays'] . $utilisateur['nomUtilisateur'] . $utilisateur['prenomUtilisateur'] . '.' . pathinfo($pdfName, PATHINFO_EXTENSION);

                // Vérifie si le fichier PDF existe et ne pas télécharger les fichiers déjà téléchargés
                if (file_exists($pdfUrl . $pdfName)) {
                    // Ajoute le PDF au fichier ZIP
                    $zip->addFile($pdfUrl . $pdfName, $newPdfName);
                }
            }

            // Ferme le fichier ZIP
            $zip->close();

            // Envoie le fichier ZIP au client pour téléchargement
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="resolution_pdfs.zip"');
            header('Content-Length: ' . filesize($zipFileName));
            readfile($zipFileName);

            // Supprime le fichier ZIP après le téléchargement
            unlink($zipFileName);
            exit();
        }
    }


    // Fonction pour récupérer les photos des étudiants
    function downloadStudentPhotos()
    {
        // Créer un dossier pour les photos si ce n'est pas déjà fait
        $targetDir = 'downloads/etudiant_photos/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Connexion à la base de données et récupération des photos
        $model = new Model('etudiant');
        $students = $model->select();
        $students = !array_key_exists(0, $students) ? [$students] : $students;

        if ($students[0] !== []) {
            // Créer un fichier ZIP pour stocker toutes les photos
            $zip = new ZipArchive();
            $zipFileName = 'downloads/etudiant_photos.zip';

            if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
                die("Impossible de créer le fichier ZIP.");
            }

            // Télécharger chaque photo dans le dossier cible et l'ajouter au fichier ZIP
            foreach ($students as $student) {
                $photoName = $student['photo']; // Assure-toi que la colonne 'photo' contient le nom du fichier photo
                $photoUrl = './photoEtudiant/'; // Le chemin vers le répertoire où les photos sont stockées
                // Crée un nom unique pour la photo (nom + prénom de l'étudiant)
                $newPhotoName = $student['nomEtudiant'] . $student['prenomEtudiant'] . $student['dateNaissance'] . '.' . pathinfo($photoName, PATHINFO_EXTENSION);

                // Vérifie si le fichier photo existe et ne pas télécharger les photos déjà téléchargées
                if (file_exists($photoUrl . $photoName)) {
                    // Ajoute la photo au fichier ZIP
                    $zip->addFile($photoUrl . $photoName, $newPhotoName);
                }
            }

            // Ferme le fichier ZIP
            $zip->close();

            // Envoie le fichier ZIP au client pour téléchargement
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="etudiant_photos.zip"');
            header('Content-Length: ' . filesize($zipFileName));
            readfile($zipFileName);

            // Supprime le fichier ZIP après le téléchargement
            unlink($zipFileName);
            exit();
        }
    }




    private function convertToCSV()
    {
        $output = fopen('php://output', 'w');
        $model = new Model($this->page);
        $data = $model->select();
        $data = !array_key_exists(0, $data) ? [$data] : $data;
        $date = date('d-m-Y');

        if ($data[0] !== []) {
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=\"$this->page$date.csv\"");
            header('Pragma: no-cache');
            header('Expires: 0');

            // Gestion des en-têtes
            $headers = array_keys($data[0]);
            array_shift($headers); // Suppression du premier champ

            // Exclure les champs "document" et "photo"
            $headers = array_filter($headers, function ($header) {
                return !in_array($header, ['document', 'photo']);
            });

            // Transformation des en-têtes : si un champ commence par 'id', on le remplace par 'nomX'
            foreach ($headers as &$header) {
                if (strpos($header, 'id') === 0) {
                    $header = 'nom' . ucfirst(substr($header, 2)); // Remplace 'idX' par 'nomX'
                }
            }
            fputcsv($output, $headers);

            // Écrire les données
            foreach ($data as $row) {
                array_shift($row); // Supprime la première colonne

                $newRow = []; // Nouveau tableau pour éviter de modifier $row en place
                foreach ($row as $key => $value) {
                    if (in_array($key, ['document', 'photo'])) {
                        continue; // On ignore ces champs
                    }

                    if (strpos($key, 'id') === 0) {
                        $tableName = ucfirst(substr($key, 2)); // Ex: idCollege → College
                        $newRow[] = $this->getEntityName($tableName, $value);
                    } else {
                        $newRow[] = $value;
                    }
                }

                fputcsv($output, $newRow);
            }
            fclose($output);
            exit();
        }
    }


    private function getEntityName($tableName, $id)
    {
        if ($tableName == "Professeur") {
            $tableName = "Utilisateur";
        }
        $model = new Model(strtolower($tableName));
        $result = $model->select(["id" . ucfirst($tableName) => $id]);
        if ($tableName == "Etudiant" || $tableName == "Utilisateur") {
            return $result["nom" . ucfirst($tableName)] . $result["prenom" . ucfirst($tableName)] ?? "Inconnu";
        }
        if ($tableName == "Theme") {
            return $result["titre"] ?? "Inconnu";
        }
        return $result["nom" . ucfirst($tableName)] ?? "Inconnu";
    }


    private function checkAuthentication()
    {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['idUtilisateur']) && $this->page !== 'connexion') {
            // Rediriger vers la page de connexion si non connecté
            $this->redirectTo("connexion");
        }
    }

    // Méthode pour charger le contrôleur et la vue associée
    public function loadPage($page)
    {
        $router = Router::getInstance();
        $modelPays = new Model("pays");
        $modelUtilisateur = new Model('utilisateur');
        $modelCollege = new Model('college');
        $modelEtudiant = new Model('etudiant');
        $modelCollegeUtilisateur = new Model('collegeUtilisateur');
        $modelResolution = new Model('resolution');
        $modelTheme = new Model('theme');
        switch ($page) {
            case 'accueil':
                if ($_SESSION['role'] == "professeur") {
                    $this->redirectTo("etudiant");
                } else {
                    require_once './views/accueil.php';
                }
                break;
            case 'connexion':
                require_once './controllers/connexion.php';
                require_once './views/connexion.php';
                break;
            case 'deconnexion':
                require_once './controllers/deconnexion.php';
                break;
            case 'etudiant':
                require_once './controllers/etudiant/etudiant.php';
                require_once './views/etudiant/etudiant.php';
                break;
            case 'formEtudiantInsert':
                require_once './controllers/etudiant/formEtudiantInsert.php';
                require_once './views/etudiant/formEtudiantInsert.php';
                break;
            case 'formEtudiantUpdate':
                require_once './controllers/etudiant/formEtudiantUpdate.php';
                require_once './views/etudiant/formEtudiantUpdate.php';
                break;
            case 'deleteEtudiant':
                require_once './controllers/etudiant/deleteEtudiant.php';
                break;
            case 'pays':
                require_once './controllers/pays/pays.php';
                require_once './views/pays/pays.php';
                break;
            case 'formPaysInsert':
                require_once './controllers/pays/formPaysInsert.php';
                require_once './views/pays/formPaysInsert.php';
                break;
            case 'formPaysUpdate':
                require_once './controllers/pays/formPaysUpdate.php';
                require_once './views/pays/formPaysUpdate.php';
                break;
            case 'deletePays':
                require_once './controllers/pays/deletePays.php';
                break;
            case 'college':
                require_once './controllers/college/college.php';
                require_once './views/college/college.php';
                break;
            case 'formCollegeInsert':
                require_once './controllers/college/formCollegeInsert.php';
                require_once './views/college/formCollegeInsert.php';
                break;
            case 'formCollegeUpdate':
                require_once './controllers/college/formCollegeUpdate.php';
                require_once './views/college/formCollegeUpdate.php';
                break;
            case 'deleteCollege':
                require_once './controllers/college/deleteCollege.php';
                break;
            case 'resolution':
                require_once './controllers/resolution/resolution.php';
                require_once './views/resolution/resolution.php';
                break;
            case 'formResolutionInsert':
                require_once './controllers/resolution/formResolutionInsert.php';
                require_once './views/resolution/formResolutionInsert.php';
                break;
            case 'formResolutionUpdate':
                require_once './controllers/resolution/formResolutionUpdate.php';
                require_once './views/resolution/formResolutionUpdate.php';
                break;
            case 'deleteResolution':
                require_once './controllers/resolution/deleteResolution.php';
                break;
            case 'theme':
                require_once './controllers/theme/theme.php';
                require_once './views/theme/theme.php';
                break;
            case 'formThemeInsert':
                require_once './controllers/theme/formThemeInsert.php';
                require_once './views/theme/formThemeInsert.php';
                break;
            case 'formThemeUpdate':
                require_once './controllers/theme/formThemeUpdate.php';
                require_once './views/theme/formThemeUpdate.php';
                break;
            case 'deleteTheme':
                require_once './controllers/theme/deleteTheme.php';
                break;
            case 'user':
                require_once './controllers/user/user.php';
                require_once './views/user/user.php';
                break;
            case 'formUserInsert':
                require_once './controllers/user/formUserInsert.php';
                require_once './views/user/formUserInsert.php';
                break;
            case 'formUserInsertAdmin':
                require_once './controllers/user/formUserInsertAdmin.php';
                require_once './views/user/formUserInsertAdmin.php';
                break;
            case 'deleteUser':
                require_once './controllers/user/deleteUser.php';
                break;
            case 'moncompte':
                require_once './controllers/compte.php';
                require_once './views/compte.php';
                break;
            default:
                if ($_SESSION['role'] == "professeur") {
                    $this->redirectTo("etudiant");
                } else {
                    require_once './views/accueil.php';
                }
                break;
        }
    }

    // Méthode pour charger la vue
    public function loadView($view)
    {
        $viewPath = "./views/{$view}.php";
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "Vue introuvable : {$viewPath}";
        }
    }

    // Méthode pour charger le controller
    public function loadController($controller)
    {
        $controllerPath = "./controllers/{$controller}.php";
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
        } else {
            echo "Vue introuvable : {$controllerPath}";
        }
    }

    // Getter pour la page
    public function getPage()
    {
        if (isset($_GET['page'])) {
            $this->page = htmlspecialchars($_GET['page']);
        }
        return $this->page;
    }

    // Méthode de redirection
    public function redirectTo($page)
    {
        $this->page = $page;
        header("Location: ?page=$this->page");
        exit;
    }

    // Liste des pages où les barres de navigation ne doivent pas apparaître
    public function showNav()
    {
        $noNavPages = ['connexion'];
        return !in_array($this->page, $noNavPages);
    }
}
