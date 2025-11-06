<?php
require_once __DIR__ . '/../models/Camiseta.php';

class CamisetaController {
    private $camiseta;

    public function __construct($db) {
        $this->camiseta = new Camiseta($db);
    }

    /**
     * Obtiene y devuelve todas las camisetas en formato JSON.
     */
    public function index() {
        $stmt = $this->camiseta->getAll();
        // Devolver el resultado como JSON, evitando escapar caracteres Unicode.
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Muestra los detalles de una camiseta, aplicando descuentos si se proporciona
     * un ID de cliente a través de la URL.
     *
     * @param int $id El ID de la camiseta a mostrar.
     */
    public function show($id) {
        // Obtener el ID del cliente de los parámetros GET, si existe.
        // Si no existe, se establece como null para que getWithPrecioFinal lo maneje.
        $cliente_id = isset($_GET['cliente_id']) ? $_GET['cliente_id'] : null;

        if ($cliente_id) {
            // Si hay un cliente_id, usar la función que calcula el precio final con descuento de cliente.
            $data = $this->camiseta->getWithPrecioFinal($id, $cliente_id);
        } else {
            // Si no hay cliente_id, obtener los datos de la camiseta sin descuentos de cliente.
            $data = $this->camiseta->getById($id);
        }

        // Devolver la información de la camiseta como JSON, evitando escapar caracteres Unicode.
        // Si la camiseta no se encuentra, devuelve un mensaje de error.
        echo json_encode($data ? $data : ["error" => "Camiseta no encontrada"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Almacena una nueva camiseta en la base de datos.
     * @param array $request Datos de la camiseta a crear.
     */
    public function store($request) {
        $result = $this->camiseta->create($request);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Actualiza una camiseta existente en la base de datos.
     * Solo los campos proporcionados en el cuerpo del mensaje se actualizan.
     * @param int $id El ID de la camiseta a actualizar.
     * @param array $request Nuevos datos de la camiseta.
     */
    public function update($id, $request) {
        // Obtener los datos actuales de la camiseta desde la base de datos
        $camiseta = $this->camiseta->getById($id);

        // Si la camiseta no existe, retornar error
        if (!$camiseta) {
            echo json_encode(["error" => "Camiseta no encontrada"]);
            return;
        }

        // Mantener los valores existentes si no están presentes en el cuerpo de la solicitud
        $titulo = isset($request['titulo']) ? $request['titulo'] : $camiseta['titulo'];
        $club = isset($request['club']) ? $request['club'] : $camiseta['club'];
        $pais = isset($request['pais']) ? $request['pais'] : $camiseta['pais'];
        $tipo = isset($request['tipo']) ? $request['tipo'] : $camiseta['tipo'];
        $color = isset($request['color']) ? $request['color'] : $camiseta['color'];
        $detalles = isset($request['detalles']) ? $request['detalles'] : $camiseta['detalles'];
        $codigo_producto = isset($request['codigo_producto']) ? $request['codigo_producto'] : $camiseta['codigo_producto'];
        $precio_oferta = isset($request['precio_oferta']) ? $request['precio_oferta'] : $camiseta['precio_oferta'];
        $precio = isset($request['precio']) ? $request['precio'] : $camiseta['precio'];

        // Realizar la actualización con los datos actuales o nuevos que hayan sido enviados
        $result = $this->camiseta->update($id, [
            'titulo' => $titulo,
            'club' => $club,
            'pais' => $pais,
            'tipo' => $tipo,
            'color' => $color,
            'detalles' => $detalles,
            'codigo_producto' => $codigo_producto,
            'precio' => $precio,
            'precio_oferta' => $precio_oferta
        ]);

        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Elimina una camiseta de la base de datos.
     * @param int $id El ID de la camiseta a eliminar.
     */
    public function delete($id) {
        $result = $this->camiseta->delete($id);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
?>
