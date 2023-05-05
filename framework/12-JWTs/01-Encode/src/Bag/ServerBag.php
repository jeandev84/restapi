<?php

class ServerBag
{

      protected $params = [];

      public function __construct(array $params = [])
      {
          $this->params = $params ?: $_SERVER;
      }


      public function getHeaders()
      {
          $headers = [];

          foreach ($_SERVER as $name => $value) {
              if (substr($name, 0, 5) == 'HTTP_') {
                  $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
              }
          }
          return $headers;
      }


      /**
       * @return array|false|string
      */
      public function getAllHeadersTheSameThatPreviousMethods()
      {
           return getallheaders();
      }
}