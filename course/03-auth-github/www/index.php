<?php

/*
SPECIFIC REQUEST HEADER RECOMMENDATION
https://docs.github.com/en/rest/reference/activity#starring

CHECK here https://github.com/settings/developers (OAuth Apps)

*/
$ch = curl_init();

$headers = [
    "Authorization: token YOUR_ACCESS_KEY",
    //"User-Agent: user_demo"
];

# own => "user_demo"
curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.github.com/user/starred/{own}/{repo}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_USERAGENT  => "user_demo"
]);

$response      = curl_exec($ch);
$statusCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo $statusCode."\n";
// echo $response."\n";