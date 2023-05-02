<?php

$ch = curl_init();

// Gist ID
$individualHash = "637365405ca043619607a30b07264a20";

curl_setopt_array($ch, [
    /* CURLOPT_URL => "https://api.github.com/gists",*/
    CURLOPT_URL => "https://api.github.com/gists/{$individualHash}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT  => "brown"
]);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);
print_r($data);

/*
CURLOPT_URL => "https://api.github.com/gists" (FULL DATA)
foreach ($data as $gist) {
    echo $gist["id"], " - ", $gist["description"], "\n";
}
*/