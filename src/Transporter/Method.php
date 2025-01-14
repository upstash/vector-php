<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
enum Method: string
{
    case GET = 'GET';
    case DELETE = 'DELETE';

    case POST = 'POST';

    public function isMutation(): bool
    {
        return match ($this) {
            self::GET => false,
            default => true,
        };
    }
}
