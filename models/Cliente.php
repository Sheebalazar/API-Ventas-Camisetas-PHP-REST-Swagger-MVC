 <?php
class Cliente {
    private $conn;
    private $table = "clientes";

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

    public function create($data) {
        // Validar datos obligatorios
        if (empty($data['nombre_comercial']) || empty($data['rut']) || empty($data['categoria'])) {
            return ["error" => "Faltan campos obligatorios"];
        }

        // Verificar RUT único
        $stmt = $this->conn->prepare("SELECT id FROM $this->table WHERE rut = ?");
        $stmt->execute([$data['rut']]);
        if ($stmt->rowCount() > 0) {
            return ["error" => "RUT ya registrado"];
        }

        $sql = "INSERT INTO $this->table (nombre_comercial, rut, direccion, categoria, contacto_nombre, contacto_email, porcentaje_oferta)
                VALUES (:nombre_comercial, :rut, :direccion, :categoria, :contacto_nombre, :contacto_email, :porcentaje_oferta)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre_comercial' => $data['nombre_comercial'],
            ':rut' => $data['rut'],
            ':direccion' => $data['direccion'],
            ':categoria' => $data['categoria'],
            ':contacto_nombre' => $data['contacto_nombre'],
            ':contacto_email' => $data['contacto_email'],
            ':porcentaje_oferta' => $data['porcentaje_oferta']
        ]);

        return ["success" => true, "id" => $this->conn->lastInsertId()];
    }

    public function update($id, $data) {
        $sql = "UPDATE $this->table SET
                    nombre_comercial = :nombre_comercial,
                    rut = :rut,
                    direccion = :direccion,
                    categoria = :categoria,
                    contacto_nombre = :contacto_nombre,
                    contacto_email = :contacto_email,
                    porcentaje_oferta = :porcentaje_oferta
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre_comercial' => $data['nombre_comercial'],
            ':rut' => $data['rut'],
            ':direccion' => $data['direccion'],
            ':categoria' => $data['categoria'],
            ':contacto_nombre' => $data['contacto_nombre'],
            ':contacto_email' => $data['contacto_email'],
            ':porcentaje_oferta' => $data['porcentaje_oferta'],
            ':id' => $id
        ]);

        return ["success" => true];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return ["success" => true];
    }
}
?>

