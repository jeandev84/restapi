<?php


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

$accessToken  = $jwt->encode($payload);
$refresh_token_expiry = time() + 432000; # 2 days (for example);

$refreshToken = $jwt->encode([
    "sub" => $user["id"],
    "exp" => $refresh_token_expiry
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