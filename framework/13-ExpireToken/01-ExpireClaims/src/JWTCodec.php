<?php


/**
 * SECRET KEY see more here : https://datatracker.ietf.org/doc/html/rfc7518#section-3-2
 * ALGO : [HS256, HS384, HS512]
 *
 * algo HS256 ===> HMAC using SHA-256
 * algo HS384 ===> HMAC using SHA-384
 * algo HS512 ===> HMAC using SHA-512
 *
 * HASH MAC see more here: https://www.php.net/manual/en/function.hash-hmac.php
 *
 *
 * Random 256-bit key generator
 * https://www.allkeysgenerator.com
 * https://www.allkeysgenerator.com/Random/Security-Encryption-Key-Generator.aspx
 *
 * https://randomkeygen.com
 *
 * https://keygen.io
 *
 *
 * Compare hash see more https://www.php.net/manual/en/function.hash-equals
 * hash_equals()
*/
class JWTCodec
{

     /**
      * @param string $secretKey
     */
     public function __construct(private string $secretKey)
     {
     }

     /**
      * @param array $payload
      * @return string
     */
     public function encode(array $payload): string
     {
         # ALGO (HASH_MAC)
         $header = json_encode([
             "typ" => "JWT",
             "alg" => "HS256"
         ]);

         $header = $this->base64urlEncode($header);

         $payload = json_encode($payload);
         $payload = $this->base64urlEncode($payload);

         $signature = hash_hmac("sha256", $header. ".". $payload . ".". $this->secretKey, true);

         $signature = $this->base64urlEncode($signature);

         return $header . "." . $payload . "." . $signature;
     }


     /**
      * @param string $token
      * @return array
      * @throws Exception
     */
     public function decode(string $token): array
     {
         if(preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/", $token, $matches) !== 1) {
              throw new InvalidArgumentException("invalid token format");
         }

         $signature = hash_hmac("sha256", $matches["header"]. ".". $matches["payload"] . ".". $this->secretKey, true);

         $signature_from_token = $this->base64urlDecode($matches["signature"]);

         if (! hash_equals($signature, $signature_from_token)) {
              throw new InvalidSignatureException("signature doesn't match");
         }

         # Return the payload
         return json_decode($this->base64urlDecode($matches["payload"]), true);
     }



     /**
      * @param string $text
      * @return string
     */
     private function base64urlEncode(string $text): string
     {
          return str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($text));
     }


     /**
      * @param string $text
      * @return string
     */
     private function base64urlDecode(string $text): string
     {
          return base64_decode(str_replace(["-", '_'], ["+", "/"], $text));
     }
}


/*
TEST JWT ENCODE
==============================================================
$ php -a
Interactive shell

php > $payload = ["id" => 123];
php > require "src/JWTCodec.php";
php > $codec = new JWTCodec;
php > echo $codec->encode($payload);
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTIzfQ.ZWY0NjZjYmE5YTQyZjU1ZDBkMjY0NTI4MGY3MDc5NmIxMmY0YzY3NDI5ZGUyNjgwZmQxMGNmYTBjNDZhZGU3Ng
php >

========================================================
TESTING JWT DECODE
========================================================

$ php -a
Interactive shell

php > require "src/JWTCodec.php";
php > $codec = new JWTCodec;
php > $token = $codec->encode(["id" => 123]);
php > echo $token;
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTIzfQ.ZWY0NjZjYmE5YTQyZjU1ZDBkMjY0NTI4MGY3MDc5NmIxMmY0YzY3NDI5ZGUyNjgwZmQxMGNmYTBjNDZhZGU3Ng
php >
php >
php > $payload = $codec->decode($token);
php > print_r($payload);
Array
(
    [id] => 123
)
php > $payload = $codec->decode($token. "xxx");
PHP Warning:  Uncaught Exception: signature doesn't match in /home/yao/Desktop/PHPSkills/Udemy/api/www/src/JWTCodec.php:76
Stack trace:
#0 php shell code(1): JWTCodec->decode()
#1 {main}
  thrown in /home/yao/Desktop/PHPSkills/Udemy/api/www/src/JWTCodec.php on line 76
php >
php >
php >
php > $payload = $codec->decode("xxxx");
PHP Warning:  Uncaught InvalidArgumentException: invalid token format in /home/yao/Desktop/PHPSkills/Udemy/api/www/src/JWTCodec.php:68
Stack trace:
#0 php shell code(1): JWTCodec->decode()
#1 {main}
  thrown in /home/yao/Desktop/PHPSkills/Udemy/api/www/src/JWTCodec.php on line 68
php >

*/