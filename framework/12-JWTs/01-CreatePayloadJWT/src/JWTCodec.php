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
*/
class JWTCodec
{


     # from https://www.allkeysgenerator.com
     const HASH = "4D635166546A576E5A7234753777217A25432A462D4A614E645267556B587032";


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

         $signature = hash_hmac("sha256", $header. ".". $payload . ".". self::HASH, true);

         $signature = $this->base64urlEncode($signature);

         return $header . "." . $payload . "." . $signature;
     }


     /**
      * @param string $text
      * @return string
     */
     private function base64urlEncode(string $text): string
     {
          return str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($text));
     }
}


/*
$ php -a
Interactive shell

php > $payload = ["id" => 123];
php > require "src/JWTCodec.php";
php > $codec = new JWTCodec;
php > echo $codec->encode($payload);
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTIzfQ.ZWY0NjZjYmE5YTQyZjU1ZDBkMjY0NTI4MGY3MDc5NmIxMmY0YzY3NDI5ZGUyNjgwZmQxMGNmYTBjNDZhZGU3Ng
php >
*/