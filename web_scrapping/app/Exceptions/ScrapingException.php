<?php

namespace App\Exceptions;

use Exception;

class ScrapingException extends Exception
{
    // You can customize the exception further if needed
    // For instance, you could add custom logging or messages here

    public function __construct($message = "An error occurred during web scraping.", $code = 0, Exception $previous = null)
    {
        // Call the parent constructor to ensure everything is set up correctly
        parent::__construct($message, $code, $previous);
    }
}