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




     /**
      * @param array $data
      * @return string
     */
     public function create(array $data): string
     {
          $sql = "INSERT task (name, priority, is_completed) VALUES(:name, :priority, :is_completed)";

          $stmt = $this->connection->prepare($sql);

          $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);

          if (empty($data["priority"])) {
              $stmt->bindValue(":priority", NULL, PDO::PARAM_NULL);
          } else {
              $stmt->bindValue(":priority", $data["priority"], PDO::PARAM_INT);
          }

          $stmt->bindValue(":is_completed", $data["is_completed"] ?? false, PDO::PARAM_BOOL);

          $stmt->execute();

          return $this->connection->lastInsertId();
     }



     /**
      * @param string $id
      * @param array $data
      * @return int
     */
     public function update(string $id, array $data): int
     {
          $fields = [];

          if (! empty($data["name"])) {
              $fields["name"] = [
                 $data["name"],
                 PDO::PARAM_STR
              ];
          }


         if (array_key_exists("priority", $data)) {
             $fields["priority"] = [
                 $data["priority"],
                 $data["priority"]  === null ? PDO::PARAM_NULL : PDO::PARAM_INT
             ];
         }


         if (array_key_exists("is_completed", $data)) {
             $fields["is_completed"] = [
                 $data["is_completed"],
                 PDO::PARAM_BOOL
             ];
         }


         if (empty($fields)) {
             return 0;
         } else {
             /*
               0 => "name = :name"
               1 => "priority = :priority"
               2 => "is_completed = :is_completed"
        */
             $sets = array_map(function ($value) {
                 return "$value = :$value";
             }, array_keys($fields));


             # "UPDATE task SET name = :name, priority = :priority, is_completed = :is_completed WHERE id = :id"
             $sql = "UPDATE task SET ". implode(", ", $sets) . " WHERE id = :id";

             $stmt = $this->connection->prepare($sql);
             $stmt->bindValue(":id", $id, PDO::PARAM_INT);

             foreach ($fields as $name => $values) {
                 $stmt->bindValue(":$name", $values[0], $values[1]);
             }

             $stmt->execute();

             // Return number of rows updated
             return $stmt->rowCount();
         }
     }


     /**
      * @param string $id
      * @return int
     */
     public function delete(string $id): int
     {
          $sql = "DELETE FROM task WHERE id = :id";

          $stmt = $this->connection->prepare($sql);
          $stmt->bindValue(":id", $id, PDO::PARAM_INT);
          $stmt->execute();

          // Return numbers of rows deleted
          return $stmt->rowCount();
     }

}