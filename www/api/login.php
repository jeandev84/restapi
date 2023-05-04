<?php
declare(strict_types=1);

# CLIENT
# http://localhost:8000/api/login.php
require __DIR__.'/bootstrap.php';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
      // Method not allowed
      http_response_code(405);
      header("Allow: POST");
      exit;
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if (! array_key_exists('username', $data) ||
    ! array_key_exists('password', $data)) {

     // Bad request
     http_response_code(400);
     echo json_encode(["message" => "missing login credentials"]);
     exit;
}


echo json_encode($data);


