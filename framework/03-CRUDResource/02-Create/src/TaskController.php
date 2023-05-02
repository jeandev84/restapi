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
                        /* echo file_get_contents("php://input"); */
                        $data = (array) json_decode(file_get_contents("php://input"), true);
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
}