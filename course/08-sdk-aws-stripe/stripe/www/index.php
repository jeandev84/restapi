<?php

require __DIR__."/vendor/autoload.php";

/*
https://aws.amazon.com/sdk-for-php/
https://stripe.com/en-gb-es
https://stripe.com/docs/libraries#server-side-libraries
composer require stripe/stripe-php
https://stripe.com/docs/api/customers?lang=php (STRIPE API)
*/

# API KEY
$apiKey = "YOUR_API_KEY";


# STRIPE Client
$data = [
    "name" => "Bob",
    "email" => "bob@example.com"
];

$stripe = new \Stripe\StripeClient($apiKey);
$customer = $stripe->customers->create($data);
echo $customer;


# STRIPE USING CURL
/*
$data = [
  "name" => "Alice",
  "email" => "alice@example.com"
];


$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.stripe.com/v1/customers",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => $apiKey,
    CURLOPT_POSTFIELDS => http_build_query($data)
]);

$response = curl_exec($ch);

curl_close($ch);

echo $response;

$ php index.php
SEE TEST : https://dashboard.stripe.com/test/customers
*/


