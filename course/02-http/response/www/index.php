<?php

/*
 * OpenWeatherApi
 * https://openweathermap.org/price
 * https://home.openweathermap.org/api_keys
 * https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
*/

$openWeatherApiKey = "fce9f17581bc6a2d13f23aa07cbf7254";

$ch = curl_init();

/*
curl_setopt($ch, CURLOPT_URL, "https://randomuser.me/api");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt_array($ch, [
    CURLOPT_URL => "https://randomuser.me/api",
    CURLOPT_RETURNTRANSFER => true
]);
*/

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.openweathermap.org/data/2.5/wather?q=London&appid={$openWeatherApiKey}",
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo $statusCode."\n";
echo $response."\n";