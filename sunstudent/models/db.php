<?php
define('HOST', 'localhost');
define('DBNAME', 'sunStudent');
define('DBUSER', 'ubuntu');
define('DBPWD', 'Super');

class DB
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_PERSISTENT => true
            ));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function addConditionToQuery($query, $conditions)
    {
        $query .= " WHERE ";
        $clauses = [];
        foreach ($conditions as $field => $value) {
            $clauses[] = "$field = :p$field";
        }
        $query .= implode(" AND ", $clauses);
        return $query;
    }

    public function addParamToQuery($ps, $conditions, $prefixe)
    {
        foreach ($conditions as $field => $value) {
            $ps->bindValue(":$prefixe$field", $value);
        }
        return $ps;
    }

    public function prepareQuery($query)
    {
        $ps = $this->pdo->prepare($query);
        return $ps;
    }

    public function executeQuery($query, $conditions = null, $fileds = null)
    {
        try {
            if (!empty($conditions)) {
                $query = $this->addConditionToQuery($query, $conditions);
                $ps = $this->prepareQuery($query);
                $ps = $this->addParamToQuery($ps, $conditions, "p");
            } else {
                $ps = $this->prepareQuery($query);
            }
            if (!empty($fileds)) {
                $ps = $this->addParamToQuery($ps, $fileds, "f");
            }
            $ps->execute();
        } catch (PDOException $error) {
            // Log the error message or display it (depending on your environment)
            // You can log it in a file or use the following for debugging purposes:
            die("Erreur lors de l'exécution de la requête : " . $error->getMessage());
        }
        return $ps;
    }
}
?>
