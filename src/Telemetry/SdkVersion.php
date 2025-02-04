<?php

namespace Upstash\Vector\Telemetry;

use Throwable;

class SdkVersion
{
    public const UNKNOWN = 'unknown';

    public static function resolve(): string
    {
        try {
            $version = json_decode(file_get_contents(__DIR__.'/../../composer.json'), true);

            return $version['version'] ?? static::UNKNOWN;
        } catch (Throwable $e) {
            return static::UNKNOWN;
        }
    }
}
