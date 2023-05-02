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

         $data = [];

         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $row['is_completed'] = (bool)$row['is_completed'];
              $data[] = $row;
         }

         return $data;
     }




     public function get(string $id)
     {
         $sql = "SELECT * FROM task WHERE id = :id";

         $stmt = $this->connection->prepare($sql);

         $stmt->bindValue(":id", $id, PDO::PARAM_INT);

         $stmt->execute();

         $data = $stmt->fetch(PDO::FETCH_ASSOC);

         if ($data !== false) {
             $data['is_completed'] = (bool)$data['is_completed'];
         }

         return $data;
     }
}