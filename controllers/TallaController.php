<?php
require_once __DIR__ . '/../models/Talla.php';

class TallaController {
    private $talla;

    public function __construct($db) {
        $this->talla = new Talla($db);
    }

    /**
     * Obtiene y devuelve todas las tallas en formato JSON.
     */
    public function index() {
        $stmt = $this->talla->getAll();
        // Devolver el resultado como JSON, evitando escapar caracteres Unicode.
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Muestra los detalles de una talla por su ID.
     *
     * @param int $id El ID de la talla a mostrar.
     */
    public function show($id) {
        $data = $this->talla->getById($id);
        // Devolver la información de la talla como JSON, evitando escapar caracteres Unicode.
        // Si la talla no se encuentra, devuelve un mensaje de error.
        echo json_encode($data ? $data : ["error" => "Talla no encontrada"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Almacena una nueva talla en la base de datos.
     * @param array $request Datos de la talla a crear (se espera 'nombre').
     */
    public function store($request) {
        if (!isset($request['nombre'])) {
            // Devolver un mensaje de error si falta el nombre, evitando escapar caracteres Unicode.
            echo json_encode(["error" => "Nombre de talla requerido"], JSON_UNESCAPED_UNICODE);
            return;
        }
        $result = $this->talla->create($request['nombre']);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Elimina una talla de la base de datos.
     * @param int $id El ID de la talla a eliminar.
     */
    public function delete($id) {
        $result = $this->talla->delete($id);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
