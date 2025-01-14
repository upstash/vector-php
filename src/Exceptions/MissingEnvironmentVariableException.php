<?php

namespace Upstash\Vector\Exceptions;

class MissingEnvironmentVariableException extends \Exception
{
    public function __construct(string $variableName)
    {
        parent::__construct(sprintf('Missing environment variable %s', $variableName));
    }
}
