 <?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/CamisetaController.php';
require_once __DIR__ . '/../controllers/ClienteController.php';
require_once __DIR__ . '/../controllers/TallaController.php';

// Conexión DB
$db = new Database();
$conn = $db->connect();

// Detectar método y URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace("/todocamisetas-backend/public", "", $uri);
$uri = explode('?', $uri)[0]; // Quitar parámetros GET

// Obtener datos JSON del body
$input = json_decode(file_get_contents("php://input"), true);

// Ruteo por patrón
switch (true) {

    // ======= CAMISETAS =======

    case $method === 'GET' && $uri === '/camisetas':
        (new CamisetaController($conn))->index();
        break;

    case $method === 'GET' && preg_match('#^/camisetas/(\d+)$#', $uri, $m):
        (new CamisetaController($conn))->show($m[1]);
        break;

    case $method === 'POST' && $uri === '/camisetas':
        (new CamisetaController($conn))->store($input);
        break;

    case in_array($method, ['PUT', 'PATCH']) && preg_match('#^/camisetas/(\d+)$#', $uri, $m):
        (new CamisetaController($conn))->update($m[1], $input);
        break;

    case $method === 'DELETE' && preg_match('#^/camisetas/(\d+)$#', $uri, $m):
        (new CamisetaController($conn))->delete($m[1]);
        break;

    // ======= CLIENTES =======

    case $method === 'GET' && $uri === '/clientes':
        (new ClienteController($conn))->index();
        break;

    case $method === 'GET' && preg_match('#^/clientes/(\d+)$#', $uri, $m):
        (new ClienteController($conn))->show($m[1]);
        break;

    case $method === 'POST' && $uri === '/clientes':
        (new ClienteController($conn))->store($input);
        break;

    case in_array($method, ['PUT', 'PATCH']) && preg_match('#^/clientes/(\d+)$#', $uri, $m):
        (new ClienteController($conn))->update($m[1], $input);
        break;

    case $method === 'DELETE' && preg_match('#^/clientes/(\d+)$#', $uri, $m):
        (new ClienteController($conn))->delete($m[1]);
        break;

    // ======= TALLAS =======

    case $method === 'GET' && $uri === '/tallas':
        (new TallaController($conn))->index();
        break;

    case $method === 'GET' && preg_match('#^/tallas/(\d+)$#', $uri, $m):
        (new TallaController($conn))->show($m[1]);
        break;

    case $method === 'POST' && $uri === '/tallas':
        (new TallaController($conn))->store($input);
        break;

    case $method === 'DELETE' && preg_match('#^/tallas/(\d+)$#', $uri, $m):
        (new TallaController($conn))->delete($m[1]);
        break;

    // ======= DEFAULT: 404 =======

    default:
        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
        break;
}

