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
}
