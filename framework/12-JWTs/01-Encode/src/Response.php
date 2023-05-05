<?php

class Response
{

     /**
      * @var string|null
     */
     protected ?string $body;


     /**
      * @var int|null
     */
     protected ?int $statusCode;




     /**
      * @var array|null
     */
     protected ?array $headers;



     /**
      * @param string|null $body
      * @param int $statusCode
      * @param array $headers
     */
     public function __construct(?string $body, int $statusCode = 200, array $headers = [])
     {
     }


    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }


    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }


    /**
     * @return array|null
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }


    public function __toString(): string
    {
         echo $this->body;
    }
}