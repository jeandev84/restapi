<?php
declare(strict_types=1);

require_once __DIR__.'/bootstrap.php';


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


//Initialize database
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$userGateway = new UserGateway($database);

/**
 * By Default Apache disabled HTTP_AUTHORIZATION that is reason is not exist in $_SERVER
 * use apache_request_headers() see more here:
 *
 * https://www.php.net/manual/en/function.apache-request-headers.php
*/
dd($_SERVER["HTTP_AUTHORIZATION"] ?? null);

/*
$headers = apache_request_headers();
echo $headers["Authorization"];
exit;
*/

// Authentication process
$auth = new Auth($userGateway);

if (! $auth->authenticateAPIKEY()) {
      exit;
}

$userId = $auth->getUserID();

// Run Task gateway
$taskGateway = new TaskGateway($database);
$controller  = new TaskController($taskGateway, $userId);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

