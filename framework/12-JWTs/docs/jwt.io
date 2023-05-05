https://jwt.io

(3) parts [HEADER + PAYLOAD + SIGNATURE(HASH)]

$header = base64url_encode({
  "alg": "HS226",
  "typ": "JWT"
});


$payload = base64url_encode({
               "sub": 1,
               "name": "Dave"
           });


$signature = baseurl_encode(JWT_SECRET);


# JSON WEB TOKEN
$jwtToken = join(".", [$header, $payload, $signature]);


