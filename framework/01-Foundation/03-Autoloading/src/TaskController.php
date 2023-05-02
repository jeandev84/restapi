<?php

class TaskController
{
      /**
       * @param $method
       * @param $id
       * @return void
      */
      public function processRequest($method, $id)
      {
           if ($id === null) {
                switch ($method) {
                    case "GET":
                        echo "index";
                    break;
                    case "POST":
                        echo "create";
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
               }
           }
      }
}