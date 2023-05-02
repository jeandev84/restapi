<?php

class TaskGateway
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
      * @return array
     */
     public function getAll(): array
     {
         $sql = "SELECT * FROM task ORDER BY name";

         $stmt = $this->connection->query($sql);

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}