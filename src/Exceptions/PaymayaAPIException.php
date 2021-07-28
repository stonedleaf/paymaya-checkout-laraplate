<?php

namespace Stonedleaf\PaymayaCheckoutLaraplate\Exceptions;

use Exception;

class PaymayaAPIException extends Exception
{
    /**
     * PayMaya error code
     * 
     * @var string
     */
    public $code;

    /**
     * Error messages
     * 
     * @var array
     */
    public $parameters;

    /**
     * HTTP status code
     * 
     * @var int
     */
    public $status;

    /**
     * Constructor for the exception
     * 
     * @param string $message
     * @param string $code
     * @param array $parameters
     * 
     * @return void
     */
    public function __construct($message, $status, $code = '', $parameters = [])
    {
        $this->code = $code;
        $this->parameters = $parameters;
        $this->status = $status;
        parent::__construct($code . ' ' . $message);
    }
}
