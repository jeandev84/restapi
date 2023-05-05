<?php


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


// send headers to server for JSON Format encoding
header("Content-type: application/json; charset=UTF-8");
