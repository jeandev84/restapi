<?php
declare(strict_types=1);

// ini_set("display_errors", "On");

require dirname(__DIR__). "/vendor/autoload.php";


// Error Handler Register
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


// SEND HEADERS
header("Content-type: application/json; charset=UTF-8");


// INITIALISE DATABASE
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);


// RUN PROCESS
$taskGateway = new TaskGateway($database);
$controller  = new TaskController($taskGateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

