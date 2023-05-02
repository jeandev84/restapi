<?php

/*
 * http://curl.se
 *
 * (--request) the same that (-X)
 *
 * CURL COMMANDS
 * GET [ curl http://localhost:8000/api/tasks ]
 * PUT|PATCH|DELETE [ curl http://localhost:8000/api/tasks --request PATCH ]
 * OR
 * PUT|PATCH|DELETE [ curl http://localhost:8000/api/tasks -X DELETE ]
 *
 * USING https://www.postman.com/
 * GET http://localhost:8000/api/tasks
 *
 * USING https://httpie.io
 * $ http http://localhost:8000/api/tasks
 * $ http post http://localhost:8000/api/tasks
*/
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);

$resource = $parts[2];

$id = $parts[3] ?? null;

echo $resource, ", ". $id;

echo $_SERVER["REQUEST_METHOD"], "\n";

if ($resource != "tasks") {
    /*
    $reasonFraze = "Not Found"
    header("HTTP/1.1 404 Not Found");
    header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
    exit;
    */
    http_response_code(404);
    exit;
}


require dirname(__DIR__)."/src/TaskController.php";
$controller = new TaskController();
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);

