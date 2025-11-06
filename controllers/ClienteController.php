<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    private $cliente;

    public function __construct($db) {
        $this->cliente = new Cliente($db);
    }

    /**
     * Obtiene y devuelve todos los clientes en formato JSON.
     */
    public function index() {
        $stmt = $this->cliente->getAll();
        // Devolver el resultado como JSON, evitando escapar caracteres Unicode.
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Muestra los detalles de un cliente por su ID.
     *
     * @param int $id El ID del cliente a mostrar.
     */
    public function show($id) {
        $data = $this->cliente->getById($id);
        // Devolver la información del cliente como JSON, evitando escapar caracteres Unicode.
        echo json_encode($data ? $data : ["error" => "Cliente no encontrado"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     * @param array $request Datos del cliente a crear.
     */
    public function store($request) {
        $result = $this->cliente->create($request);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Actualiza un cliente existente en la base de datos.
     * Solo los campos proporcionados en el cuerpo del mensaje se actualizan.
     * @param int $id El ID del cliente a actualizar.
     * @param array $request Nuevos datos del cliente.
     */
    public function update($id, $request) {
        // Obtener los datos actuales del cliente desde la base de datos
        $cliente = $this->cliente->getById($id);

        // Si el cliente no existe, retornar error
        if (!$cliente) {
            echo json_encode(["error" => "Cliente no encontrado"]);
            return;
        }

        // Mantener los valores existentes si no están presentes en el cuerpo de la solicitud
        $nombre_comercial = isset($request['nombre_comercial']) ? $request['nombre_comercial'] : $cliente['nombre_comercial'];
        $rut = isset($request['rut']) ? $request['rut'] : $cliente['rut'];
        $direccion = isset($request['direccion']) ? $request['direccion'] : $cliente['direccion'];
        $categoria = isset($request['categoria']) ? $request['categoria'] : $cliente['categoria'];
        $contacto_nombre = isset($request['contacto_nombre']) ? $request['contacto_nombre'] : $cliente['contacto_nombre'];
        $contacto_email = isset($request['contacto_email']) ? $request['contacto_email'] : $cliente['contacto_email'];
        $porcentaje_oferta = isset($request['porcentaje_oferta']) ? $request['porcentaje_oferta'] : $cliente['porcentaje_oferta'];

        // Realizar la actualización con los datos actuales o nuevos que hayan sido enviados
        $result = $this->cliente->update($id, [
            'nombre_comercial' => $nombre_comercial,
            'rut' => $rut,
            'direccion' => $direccion,
            'categoria' => $categoria,
            'contacto_nombre' => $contacto_nombre,
            'contacto_email' => $contacto_email,
            'porcentaje_oferta' => $porcentaje_oferta
        ]);

        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Elimina un cliente de la base de datos.
     * @param int $id El ID del cliente a eliminar.
     */
    public function delete($id) {
        $result = $this->cliente->delete($id);
        // Devolver el resultado de la operación como JSON, evitando escapar caracteres Unicode.
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
?>
