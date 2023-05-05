<?php

class RefreshTokenGateway
{

      /**
       * @var PDO
      */
      protected PDO $connection;




      /**
       * @var string
      */
      protected string $secretKey;


      /**
       * @param Database $database
       * @param string $secretKey
      */
      public function __construct(Database $database, string $secretKey)
      {
          $this->connection = $database->getConnection();
          $this->secretKey  = $secretKey;
      }


       /**
        * @param string $token
        * @param int $expiry
        * @return bool
      */
      public function create(string $token, int $expiry): bool
      {
          $hash = hash_hmac("sha256", $token, $this->secretKey);

          $sql = "INSERT INTO refresh_token (token_hash, expires_at) VALUES (:token_hash, :expires_at)";

          $stmt = $this->connection->prepare($sql);

          $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);
          $stmt->bindValue(":expires_at", $expiry, PDO::PARAM_INT);

          return $stmt->execute();

      }



      public function delete(string $token)
      {
          $hash = hash_hmac("sha256", $token, $this->secretKey);

          $sql = "DELETE FROM refresh_token WHERE token_hash = :token_hash";

          $stmt = $this->connection->prepare($sql);

          $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);

          $stmt->execute();

          return $stmt->rowCount();
      }
}