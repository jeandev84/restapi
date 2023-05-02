<?php

/*
 * OpenWeatherApi
 * https://openweathermap.org/price
 * https://home.openweathermap.org/api_keys
 * https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 * https://en.wikipedia.org/wiki/List_of_HTTP_header_fields#Request_fields
 * https://en.wikipedia.org/wiki/List_of_HTTP_header_fields#Response_fields
 *
 * https://unsplash.com [Random Photos]
 * https://unsplash.com/documentation#public-authentication
 *
 * Authorization: Client-ID YOUR_ACCESS_KEY
 * https://api.unsplash.com/photos/?client_id=YOUR_ACCESS_KEY
 *
 * https://www.php.net/manual/en/function.curl-getinfo.php
*/

/*
{
  "id": "pXhwzz1JtQU",
  "updated_at": "2016-07-10T11:00:01-05:00",
  "username": "jimmyexample",
  "first_name": "James",
  "last_name": "Example",
  "twitter_username": "jimmy",
  "portfolio_url": null,
  "bio": "The user's bio",
  "location": "Montreal, Qc",
  "total_likes": 20,
  "total_photos": 10,
  "total_collections": 5,
  "followed_by_user": false,
  "downloads": 4321,
  "uploads_remaining": 4,
  "instagram_username": "james-example",
  "location": null,
  "email": "jim@example.com",
  "links": {
    "self": "https://api.unsplash.com/users/jimmyexample",
    "html": "https://unsplash.com/jimmyexample",
    "photos": "https://api.unsplash.com/users/jimmyexample/photos",
    "likes": "https://api.unsplash.com/users/jimmyexample/likes",
    "portfolio": "https://api.unsplash.com/users/jimmyexample/portfolio"
  }
}


$responseHeaders = [];

$headerCallback = function ($ch, $header) use (&$responseHeaders) {

    $len = strlen($header);

    $responseHeaders[] = $header;

    return $len;
};
*/

$ch = curl_init();

$headers = [
    "Authorization: Client-ID mJwaLbH1nmUXRYBj-KgmeTDHpn41UKOdwtZKNL39ifA"
];


$responseHeaders = [];

$headerCallback = function ($ch, $header) use (&$responseHeaders) {

    $len = strlen($header);

    $parts = explode(":", $header, 2);

    if (count($parts) < 2) {
       return $len;
    }

    $responseHeaders[$parts[0]] = trim($parts[1]);

    return $len;
};

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.unsplash.com/photos/random", // SET URL
    CURLOPT_RETURNTRANSFER => true, // RETURN BODY ==> true
    CURLOPT_HTTPHEADER => $headers, // SET REQUEST HEADERS
    CURLOPT_HEADERFUNCTION => $headerCallback, // HEADER MORE READABLE AS ARRAY
]);

$response      = curl_exec($ch);
$statusCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo $statusCode."\n";
print_r($responseHeaders);
// echo $response."\n";