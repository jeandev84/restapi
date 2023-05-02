<?php

/*
 * GUZZLE HTTP
 * composer require guzzlehttp/guzzle
 * https://docs.guzzlephp.org/en/stable
 * https://docs.guzzlephp.org/en/stable/quickstart.html#sending-requests
*/

require __DIR__."/vendor/autoload.php";

$client = new \GuzzleHttp\Client();

$response = $client->request("GET", "https://api.github.com/repos", [
    "headers" => [
        "Authorization" => "token YOUR_TOKEN",
        "User-Agent" => "janklod"
    ]
]);

echo $response->getStatusCode(). "\n";
echo $response->getHeader("content-type")[0] ."\n";
echo substr($response->getBody(), 0, 200), "...\n";
