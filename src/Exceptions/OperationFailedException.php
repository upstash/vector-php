<?php

namespace Upstash\Vector\Exceptions;

use Exception;

class OperationFailedException extends Exception
{
    public function __construct(
        $message,
    ) {
        parent::__construct($message);
    }
}
