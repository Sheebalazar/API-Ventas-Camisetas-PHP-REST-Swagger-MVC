<?php
class Camiseta {
    private $conn;
    private $table = "camisetas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los datos de una camiseta por su ID y calcula el precio final,
     * aplicando un descuento de oferta si existe y un descuento de cliente si se especifica.
     *
     * @param int $id El ID de la camiseta.
     * @param int|null $cliente_id El ID del cliente (opcional).
     * @return array|null Un array asociativo con los datos de la camiseta y el precio final,
     * o null si la camiseta no se encuentra.
     */
    public function getWithPrecioFinal($id, $cliente_id = null) {
        // Obtener datos de camiseta
        $stmt = $this->conn->prepare("SELECT * FROM camisetas WHERE id = ?");
        $stmt->execute([$id]);
        $camiseta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$camiseta) {
            return null;
        }

        // Usar precio_oferta si existe, sino el precio normal
        // Se asume que 'precio_oferta' y 'precio' son columnas numéricas en la base de datos.
        $base_precio = isset($camiseta['precio_oferta']) && $camiseta['precio_oferta'] !== null ? $camiseta['precio_oferta'] : $camiseta['precio'];

        // Inicializar precio_final con el precio base antes de aplicar descuentos adicionales
        $camiseta['precio_final'] = floatval($base_precio);

        // Si se especifica cliente, buscar su descuento
        if ($cliente_id) {
            $stmt = $this->conn->prepare("SELECT porcentaje_oferta FROM clientes WHERE id = ?");
            $stmt->execute([$cliente_id]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cliente && isset($cliente['porcentaje_oferta'])) {
                $descuento = floatval($cliente['porcentaje_oferta']);
                // Calcular el precio final aplicando el descuento del cliente
                $precio_final_con_descuento = $camiseta['precio_final'] * (1 - $descuento / 100);
                $camiseta['precio_final'] = round($precio_final_con_descuento, 2);
            }
        }

        return $camiseta;
    }

    public function create($data) {
        // Validación básica
        if (empty($data['codigo_producto']) || empty($data['precio'])) {
            return ["error" => "Faltan campos obligatorios"];
        }

        // Verificar existencia del código
        $check = $this->conn->prepare("SELECT id FROM $this->table WHERE codigo_producto = ?");
        $check->execute([$data['codigo_producto']]);
        if ($check->rowCount() > 0) {
            return ["error" => "Código de producto ya existe"];
        }

        $sql = "INSERT INTO $this->table (titulo, club, pais, tipo, color, precio, detalles, codigo_producto, precio_oferta)
                VALUES (:titulo, :club, :pais, :tipo, :color, :precio, :detalles, :codigo_producto, :precio_oferta)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':club' => $data['club'],
            ':pais' => $data['pais'],
            ':tipo' => $data['tipo'],
            ':color' => $data['color'],
            ':precio' => $data['precio'],
            ':detalles' => $data['detalles'],
            ':codigo_producto' => $data['codigo_producto'],
            ':precio_oferta' => $data['precio_oferta']
        ]);
        return ["success" => true, "id" => $this->conn->lastInsertId()];
    }

    public function update($id, $data) {
        $sql = "UPDATE $this->table SET
                    titulo = :titulo,
                    club = :club,
                    pais = :pais,
                    tipo = :tipo,
                    color = :color,
                    precio = :precio,
                    detalles = :detalles,
                    codigo_producto = :codigo_producto,
                    precio_oferta = :precio_oferta
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':club' => $data['club'],
            ':pais' => $data['pais'],
            ':tipo' => $data['tipo'],
            ':color' => $data['color'],
            ':precio' => $data['precio'],
            ':detalles' => $data['detalles'],
            ':codigo_producto' => $data['codigo_producto'],
            ':precio_oferta' => $data['precio_oferta'],
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
