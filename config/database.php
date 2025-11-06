<?php
class Database {
    private $host = "localhost";
    private $db_name = "todocamisetas";
    private $username = "root";
    private $password = "";
    public $conn;

    /**
     * Establece la conexión a la base de datos.
     * @return PDO|null Objeto PDO si la conexión es exitosa, null en caso contrario.
     */
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4", // Importante: el charset en la DSN es crucial
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Confirmación de conexión exitosa, ahora con JSON_UNESCAPED_UNICODE
            echo json_encode(["status" => "Conexión exitosa"], JSON_UNESCAPED_UNICODE);
        } catch(PDOException $exception) {
            // Manejo de errores de conexión, también con JSON_UNESCAPED_UNICODE
            echo json_encode(["error" => "Error de conexión: " . $exception->getMessage()], JSON_UNESCAPED_UNICODE);
        }

        return $this->conn;
    }
}
