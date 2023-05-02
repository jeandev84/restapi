<?php

/*
 * DSN: Data Source Name
 *
 * https://www.php.net/manual/en/language.oop5.decon.php#language.oop5.decon.constructor.promotion
*/
class Database
{
       public function __construct(
           protected string $host,
           protected string $name,
           protected string $user,
           protected string $password
       )
       {
       }


       /**
        * @return PDO
       */
       public function getConnection(): PDO
       {
           $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";

           return new PDO($dsn, $this->user, $this->password, [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
           ]);
       }
}