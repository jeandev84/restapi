<?php

class Auth
{


     /**
       * @param UserGateway $userGateway
     */
     public function __construct(protected UserGateway $userGateway)
     {
     }



     /**
      * @return bool
     */
     public function authenticateAPIKEY(): bool
     {

         if (empty($_SERVER["HTTP_X_API_KEY"])) {
             http_response_code(400);
             echo json_encode(["message" => "missing API key"]);
             return false;
         }

         $api_key = $_SERVER["HTTP_X_API_KEY"];

         if($this->userGateway->getByAPIKey($api_key) === false) {
             /*** https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401 */
             # Unauthorized
             http_response_code(401);
             echo json_encode(["message" => "Invalid API key"]);
             return false;
         }

         return true;
     }
}