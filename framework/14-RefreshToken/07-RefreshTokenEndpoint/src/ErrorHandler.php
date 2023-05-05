<?php

class ErrorHandler
{


      /**
       * @param int $errno
       * @param string $errstr
       * @param string $errfile
       * @param int $errline
       * @return void
      */
     public static function handleError(
         int $errno,
         string $errstr,
         string $errfile,
         int $errline
     ): void
     {
           throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
     }


     public static function handleException(Throwable $exception): void
     {
          http_response_code(500);
          echo json_encode([
              "code" => $exception->getCode(),
              "file"    => $exception->getFile(),
              "line"    => $exception->getLine(),
              "message" => $exception->getMessage()
          ], JSON_PRETTY_PRINT);
     }
}