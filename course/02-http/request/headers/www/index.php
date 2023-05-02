<?php

/*
 * OpenWeatherApi
 * https://openweathermap.org/price
 * https://home.openweathermap.org/api_keys
 * https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 * https://en.wikipedia.org/wiki/List_of_HTTP_header_fields#Request_fields
 * https://unsplash.com [Random Photos]
 * https://unsplash.com/documentation#public-authentication
 *
 * Authorization: Client-ID YOUR_ACCESS_KEY
 * https://api.unsplash.com/photos/?client_id=YOUR_ACCESS_KEY
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
*/
$ch = curl_init();

$headers = [
    /* "Authorization: Client-ID YOUR_ACCESS_KEY" */
    "Authorization: Client-ID mJwaLbH1nmUXRYBj-KgmeTDHpn41UKOdwtZKNL39ifA"
];


curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.unsplash.com/photos/random",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);

$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo $statusCode."\n";
echo $response."\n";