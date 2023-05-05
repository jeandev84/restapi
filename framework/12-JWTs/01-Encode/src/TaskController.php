<?php

class TaskController
{


      /**
       * @param TaskGateway $gateway
       * @param int $userId
      */
      public function __construct(protected TaskGateway $gateway, protected int $userId)
      {
      }




      /**
       * @param string $method
       * @param string|null $id from URL
       * @return void
      */
      public function processRequest(string $method, ?string $id): void
      {
           if ($id === null) {
                switch ($method) {
                    case "GET":
                        echo json_encode($this->gateway->getAllForUser($this->userId));
                    break;
                    case "POST":

                        $data = (array) json_decode(file_get_contents("php://input"), true);
                        $errors = $this->getValidationErrors($data);

                        if (! empty($errors)) {
                            $this->respondUnprocessabbleEntity($errors);
                            return;
                        }

                        $id = $this->gateway->createForUser($this->userId, $data);
                        $this->respondCreated($id);

                    break;
                    default:
                        $this->respondMethodNotAllowed("GET, POST");
                    break;
                }
           } else {

               $task = $this->gateway->getForUser($this->userId, $id);

               if ($task === false) {
                   $this->respondNotFound($id);
                   return;
               }

               switch ($method) {
                   case "GET":
                       echo json_encode($task);
                   break;
                   case "PATCH":
                       $data = (array) json_decode(file_get_contents("php://input"), true);
                       $errors = $this->getValidationErrors($data, false);

                       if (! empty($errors)) {
                           $this->respondUnprocessabbleEntity($errors);
                           return;
                       }

                       $rows = $this->gateway->updateForUser($this->userId, $id, $data);
                       echo json_encode(["message" => "Task updated", "rows" => $rows]);
                   break;
                   case "DELETE":
                       $rows = $this->gateway->deleteForUser($this->userId, $id);
                       echo json_encode(["message" => "Task deleted", "rows" => $rows]);
                   break;
                   default:
                       $this->respondMethodNotAllowed("GET, PATCH, DELETE");
                   break;
               }
           }
      }




      /**
       * @param array $errors
       * @return void
      */
      private function respondUnprocessabbleEntity(array $errors): void
      {
           http_response_code(422);
           echo json_encode(["errors" => $errors]);
      }



      /**
       * @param string $allowedMethods
       * @return void
      */
      private function respondMethodNotAllowed(string $allowedMethods): void
      {
           http_response_code(405);
           header("Allow: $allowedMethods");
      }




      /**
       * @param string $id
       * @return void
      */
      private function respondNotFound(string $id): void
      {
          http_response_code(404);
          echo json_encode(["message" => "Task with ID $id not found"]);
      }





      /**
       * @param string $id
       * @return void
      */
      private function respondCreated(string $id): void
      {
          http_response_code(201);
          echo json_encode([
              "message" => "Task created",
              "id" => $id
          ]);
      }


     /**
      * @param array $data
      * @param bool $isNew
      * @return array
     */
      private function getValidationErrors(array $data, bool $isNew = true): array
      {
           $errors = [];

           if ($isNew && empty($data["name"])) {
               $errors[] = "name is required";
           }

           if (! empty($data["priority"])) {
               if (filter_var($data["priority"], FILTER_VALIDATE_INT) === false) {
                    $errors[] = "priority must be an integer";
               }
           }

           return $errors;
      }
}