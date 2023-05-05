<?php

class Auth
{


    /**
     * Current User ID
     *
     * @var int
    */
    protected int $userId;


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
         $user = $this->userGateway->getByAPIKey($api_key) ;

         if($user === false) {
             /*** https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401 */
             # Unauthorized
             http_response_code(401);
             echo json_encode(["message" => "Invalid API key"]);
             return false;
         }

         $this->userId = $user["id"];

         return true;
     }


    /**
     * @return int
    */
    public function getUserID(): int
    {
        return $this->userId;
    }



     /**
      * Returns true if the Access token is valid
      * Otherwise return false
      *
      * @return bool
     */
     public function authenticateAccessToken(): bool
     {
          if(! preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"] ?? "", $matches)) {
               http_response_code(400);
               echo json_encode(["message" => "incomplete authorization header"]);
               return false;
          }

          $plainText = base64_decode($matches[1], true);

          if ($plainText === false) {
               http_response_code(400);
               echo json_encode(["message" => "invalid authorization header"]);
               return false;
          }

          $data = json_decode($plainText, true);

          if ($data === null) {
             http_response_code(400);
             echo json_encode(["message" => "invalid json"]);
             return false;
          }


          /* dd($matches[1], $plainText, $data); */


          $this->userId = $data["id"];

          return true;
     }
}