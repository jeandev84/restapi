<?php
declare(strict_types=1);

# CLIENT
# http://localhost:8000/api/login.php
require __DIR__ . '/bootstrap.php';

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

if (! array_key_exists('username', $data) ||
    ! array_key_exists('password', $data)) {

     // Bad request
     http_response_code(400);
     echo json_encode(["message" => "missing login credentials"]);
     exit;
}


# Check user by username
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$userGateway = new UserGateway($database);

$user = $userGateway->getByUsername($data["username"]);

if ($user === false) {
    # Unauthorized
    http_response_code(401);
    echo json_encode(["message" => "invalid authentication"]);
    exit;
}


# Verify User password
if (! password_verify($data["password"], $user["password_hash"])) {
     # Unauthorized
     http_response_code(401);
     echo json_encode(["message" => "invalid authentication"]);
     exit;
}

/*
# echo json_encode($user);
# echo json_encode("Successful authentication");
# Encoding User credentials
# https://www.php.net/manual/en/function.base64-encode.php

$payload = [
  "id" => $user["id"],
  "name" => $user["name"],
  "roles" => $user["roles"]
];

$ php -a
Interactive shell

php > $encoded = base64_encode("hello world");
php > echo $encoded;
aGVsbG8gd29ybGQ=
php > echo base64_decode($encoded);
hello world
php >

*/



# exp: TTL (Expire Claims)
# exp: time() + 3600 (1h)
# exp: time() + 300 (30s)
# exp: time() + 20  (2s)
$payload = [
  "sub" => $user["id"],
  "name" => $user["name"],
  "exp"  => time() + 20 # 2 seconds (recommended)
];


# $accessToken = base64_encode(json_encode($payload));


$jwt = new JWTCodec($_ENV["JWT_SECRET_KEY"]);
$accessToken  = $jwt->encode($payload);
$refreshToken = $jwt->encode([
    "sub" => $user["id"],
    "exp" => time() + 432000, # 2 days (for example)
]);


echo json_encode([
    "access_token"  => $accessToken,
    "refresh_token" => $refreshToken
]);

/*
{
    "access_token": "eyJpZCI6MywibmFtZSI6IkRlbW8ifQ=="
}

php -a
Interactive shell

php > echo base64_decode("eyJpZCI6MywibmFtZSI6IkRlbW8ifQ==");
{"id":3,"name":"Demo"}
php >
*/


