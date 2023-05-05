<?php

declare(strict_types=1);

# CLIENT
# http://localhost:8000/api/refresh.php
require __DIR__.'/bootstrap.php';

$jsonCredentials = '{
    "username": "demo",
    "password": "demo"
}';


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Method not allowed
    http_response_code(405);
    header("Allow: POST");
    exit;
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if (! array_key_exists('token', $data)) {

    // Bad request
    http_response_code(400);
    echo json_encode(["message" => "missing token"]);
    exit;
}


/* echo $data["token"]; */

$jwt = new JWTCodec($_ENV["JWT_SECRET_KEY"]);


try {

    $payload = $jwt->decode($data["token"]);

} catch (Exception $e) {

    http_response_code(400);
    echo json_encode(["message" => "invalid token"]);
    exit;
}



$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$refreshTokenGateway = new RefreshTokenGateway($database, $_ENV["JWT_SECRET_KEY"]);

$refreshTokenGateway->delete($data["token"]);
