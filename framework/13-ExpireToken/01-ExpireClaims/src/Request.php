<?php

class Request
{

      public array $server;

      public array $request;


      public function __construct()
      {
          $this->server  = $_SERVER;
          $this->request = $_POST;
      }
}