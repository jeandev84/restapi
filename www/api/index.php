<?php
declare(strict_types=1);


/**
 * GET : http://localhost:8000/api/tasks
 * GET : http://localhost:8000/api/tasks/{id}
 * POST : http://localhost:8000/api/tasks
 * PATCH : http://localhost:8000/api/tasks/{id}
 * DELETE : http://localhost:8000/api/tasks/{id}
*/
// ini_set("display_errors", "On");

require dirname(__DIR__). "/vendor/autoload.php";


// Error Handler Register
set_error_handler("ErrorHandler::handleError");


// Exception Handler Register
set_exception_handler("ErrorHandler::handleException");



// Load Environments
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


// Front Controller
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[2];

$id = $parts[3] ?? null;

if ($resource != "tasks") {
    http_response_code(404);
    exit;
}


/**
 * GET ALL HEADERS HTTP REQUEST
 * https://www.php.net/manual/en/function.getallheaders.php
 *
 * https://en.wikipedia.org/wiki/Application_programming_interface_key
 * GET /something HTTP/1.1
 * X-API: abcdef123445
 *
 * X-API-Key:abc123 (will be in $_SERVER where $_SERVER["HTTP_X_API_KEY"])
 *
 * Bad Request: https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400
*/

// $api_key = $_GET['api-key'];
// echo $api_key;
// print_r($_SERVER);

if (empty($_SERVER["HTTP_X_API_KEY"])) {
    http_response_code(400);
    echo json_encode(["message" => "missing API key"]);
    exit;
}

$api_key = $_SERVER["HTTP_X_API_KEY"];
echo $api_key;
exit;

// send headers to server for JSON Format encoding
header("Content-type: application/json; charset=UTF-8");


// INITIALISE DATABASE
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);


// RUN PROCESS
$taskGateway = new TaskGateway($database);
$controller  = new TaskController($taskGateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

