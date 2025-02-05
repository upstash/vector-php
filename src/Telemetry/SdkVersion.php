<?php

namespace Upstash\Vector\Telemetry;

use Throwable;

class SdkVersion
{
    public const UNKNOWN = 'unknown';

    public static function resolve(): string
    {
        try {
            $composerContents = file_get_contents(__DIR__.'/../../composer.json');
            if (! $composerContents) {
                return static::UNKNOWN;
            }

            $json = json_decode($composerContents, true);
            if (! isset($json['version'])) {
                return static::UNKNOWN;
            }

            return $json['version'];
        } catch (Throwable $e) {
            return static::UNKNOWN;
        }
    }
}
