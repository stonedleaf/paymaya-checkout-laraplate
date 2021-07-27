<?php

namespace Stonedleaf\PaymayaLaravel\Exceptions;

use Exception;

class InvalidPayloadException extends Exception
{
    /**
     * @var string
     */
    public $id;

    public function __construct($message, $id)
    {
        $this->id = $id;
        parent::__construct($message . ' ' . $id);
    }
}