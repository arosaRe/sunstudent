<?php
class Model
{
    private $db;
    private $nomTable;

    public function __construct($inNom)
    {
        $this->db = DB::getInstance();
        if ($this->tableExists($inNom)) {
            $this->nomTable = $inNom;
        } else {
            throw new Exception("La table '$inNom' n'existe pas dans la base de données.");
        }
    }

    /**
     * Vérifie si une table existe dans la base de données.
     * 
     * @param string $tableName Nom de la table à vérifier.
     * @return bool True si la table existe, false sinon.
     */
    private function tableExists($tableName)
    {
        $query = "SELECT COUNT(*) FROM information_schema.tables 
                  WHERE table_schema = DATABASE() AND table_name = :tableName";
        $result = DB::getInstance()->getPDO()->prepare($query);
        $result->execute([':tableName' => $tableName]);
        return $result->fetchColumn() > 0;
    }

    public function select(array $conditions = null)
    {
        $query = "SELECT * FROM $this->nomTable";

        try {
            $ps = $this->db->executeQuery($query, $conditions);
        } catch (PDOException $error) {
            return "Erreur lors de la sélection des données : " . $error->getMessage();
        }

        $result = $ps->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) == 1) {
            return $result[0];
        }
        return $result;
    }

    public function update(array $fields, array $conditions)
    {
        $query = "UPDATE $this->nomTable SET ";
        $clauses = [];
        foreach ($fields as $field => $value) {
            $clauses[] = "$field = :f$field";
        }
        $query .= implode(", ", $clauses);

        try {
            $this->db->executeQuery($query, $conditions, $fields);
        } catch (PDOException $error) {
            return "Erreur lors de la mise à jour des données : " . $error->getMessage();
        }
        return true;
    }

    public function insert(array $fields)
    {
        $valueModified = [];
        foreach ($fields as $field => $value) {
            $valueModified[] = ":f$field";
        }
        $nameFields = implode(", ", array_keys($fields));
        $valueFields = implode(", ", $valueModified);
        $query = "INSERT INTO $this->nomTable ($nameFields) VALUES ($valueFields)";

        try {
            $this->db->executeQuery($query, null, $fields);
        } catch (PDOException $error) {
            return "Erreur lors de l'insertion des données : " . $error->getMessage();
        }
        return DB::getInstance()->getPDO()->lastInsertId();
    }

    public function delete(array $conditions = null)
    {
        $query = "DELETE FROM $this->nomTable";

        try {
            $ps = $this->db->executeQuery($query, $conditions);
        } catch (PDOException $error) {
            return "Erreur lors de la suppression des données : " . $error->getMessage();
        }

        return $ps->rowCount();
    }
}
?>
