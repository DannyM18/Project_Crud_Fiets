<?php
    namespace ProjectCrudFiets\classes;
// auteur: Danny Matthijssen
// functie: Database verbindingsklasse

use \PDO;
use \PDOException;
use ProjectCrudFiets\classes\Fiets;

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    private $table = 'fietsen';

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->servername . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Haal alle fietsen op
    public function getAll(): array {
        $conn = $this->conn;
        $sql = "SELECT * FROM " . $this->table;
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        
        return $result ? $result : [];
    }

    // Haal één fiets op basis van ID
    public function getById($id): ?Fiets {
        $conn = $this->conn;
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute([':id' => $id]);
        $row = $query->fetch();

        if ($row) {
            return new Fiets($row['merk'], $row['type'], $row['prijs'], $row['id']);
        }
        return null;
    }

    // Voeg fiets toe
    public function insert(Fiets $fiets): bool {
        try {
            $conn = $this->conn;
            $sql = "INSERT INTO " . $this->table . " (merk, type, prijs) 
                    VALUES (:merk, :type, :prijs)";
            
            $values = [
                ':merk' => $fiets->getMerk(),
                ':type' => $fiets->getType(),
                ':prijs' => $fiets->getPrijs()
            ];

            $stmt = $conn->prepare($sql);
            $stmt->execute($values);

            return $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            $this->handleError($e, $sql, $values ?? []);
            return false;
        }
    }

    // Update fiets
    public function update(Fiets $fiets): bool {
        try {
            $conn = $this->conn;
            $sql = "UPDATE " . $this->table . " 
                    SET merk = :merk, type = :type, prijs = :prijs 
                    WHERE id = :id";

            $values = [
                ':merk' => $fiets->getMerk(),
                ':type' => $fiets->getType(),
                ':prijs' => $fiets->getPrijs(),
                ':id' => $fiets->getId()
            ];

            $stmt = $conn->prepare($sql);
            $stmt->execute($values);

            return $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            $this->handleError($e, $sql, $values ?? []);
            return false;
        }
    }

    // Verwijder fiets
    public function delete($id): bool {
        try {
            $conn = $this->conn;
            $sql = "DELETE FROM " . $this->table . " WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            $this->handleError($e, $sql, [':id' => $id]);
            return false;
        }
    }

    // Foutafhandeling
    private function handleError(PDOException $e, string $sql, array $values): void {
        $err = "
        <h2>Foutmelding</h2>
        Fout op bestand: " . $e->getFile() . " op regel " . $e->getLine() . "<br>" .
        "SQL-fout: " . $e->getMessage() . "<br>" .
        "Foute SQL: " . $sql . "<br>" .
        "Opgegeven waarden: " . print_r($values, true) . "<br><br>";
        echo $err;
    }
}
?>
