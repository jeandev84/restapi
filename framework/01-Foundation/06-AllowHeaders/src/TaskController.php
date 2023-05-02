<?php

class TaskController
{
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
                        echo "index";
                    break;
                    case "POST":
                        echo "create";
                    break;
                    default:
                        $this->respondMethodNotAllowed("GET, POST");
                    break;
                }
           } else {
               switch ($method) {
                   case "GET":
                       echo "show $id";
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
}