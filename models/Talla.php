 <?php
class Talla {
    private $conn;
    private $table = "tallas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre) {
        // Validar existencia
        $check = $this->conn->prepare("SELECT id FROM $this->table WHERE nombre = ?");
        $check->execute([$nombre]);
        if ($check->rowCount() > 0) {
            return ["error" => "Talla ya existe"];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
        return ["success" => true, "id" => $this->conn->lastInsertId()];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return ["success" => true];
    }
}
?>

