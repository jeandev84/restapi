<?php

class UserGateway
{

    /**
     * @var PDO
     */
    private PDO $connection;

    public function __construct(Database $database)
    {
        $this->connection = $database->getConnection();
    }


    /**
     * @param string $key
     * @return array|false
    */
    public function getByAPIKey(string $key): array|false
    {
         $sql = "SELECT * FROM user WHERE api_key = :api_key";

         $stmt = $this->connection->prepare($sql);

         $stmt->bindValue(":api_key", $key, PDO::PARAM_STR);

         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * @param string $username
     * @return mixed
    */
    public function getByUsername(string $username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * @param int $id
     * @return array|false
    */
    public function getByID(int $id): array|false
    {
         $sql = "SELECT * FROM user WHERE id = :id";

         $stmt = $this->connection->prepare($sql);

         $stmt->bindValue(":id", $id, PDO::PARAM_INT);

         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}