<?php

namespace Upstash\Vector\Exceptions;

class MissingEnvironmentVariableException extends \Exception
{
    public function __construct(string $variableName)
    {
        parent::__construct(sprintf('Missing environment variable %s, you can get this from your Upstash Console.', $variableName));
    }
}
