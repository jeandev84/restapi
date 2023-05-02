<?php

class TaskController
{


      /**
       * @param TaskGateway $gateway
      */
      public function __construct(protected TaskGateway $gateway)
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
                        echo json_encode($this->gateway->getAll());
                    break;
                    case "POST":

                        $data = (array) json_decode(file_get_contents("php://input"), true);
                        $errors = $this->getValidationErrors($data);

                        if (! empty($errors)) {
                            $this->respondUnprocessabbleEntity($errors);
                            return;
                        }

                        $id = $this->gateway->create($data);
                        $this->respondCreated($id);

                    break;
                    default:
                        $this->respondMethodNotAllowed("GET, POST");
                    break;
                }
           } else {

               $task = $this->gateway->get($id);

               if ($task === false) {
                   $this->respondNotFound($id);
                   return;
               }

               switch ($method) {
                   case "GET":
                       echo json_encode($task);
                   break;
                   case "PATCH":
                       echo "update $id";
                   break;
                   case "DELETE":
                       echo "delete $id";
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




      private function getValidationErrors(array $data): array
      {
           $errors = [];

           if (empty($data["name"])) {
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