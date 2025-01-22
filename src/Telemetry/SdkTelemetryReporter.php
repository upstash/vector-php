<?php

namespace Upstash\Vector\Telemetry;

use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @internal
 */
final readonly class SdkTelemetryReporter
{
    public function appendHeaders(RequestInterface $request): RequestInterface
    {
        return $request
            ->withHeader('Upstash-Telemetry-Runtime', $this->getRuntime())
            ->withHeader('Upstash-Telemetry-Package', $this->getPackageVersion());
    }

    public function getRuntime(): string
    {
        try {
            return sprintf('php%s', phpversion());
        } catch (Throwable $e) {
            return 'php';
        }
    }

    public function getPackageVersion(): string
    {
        try {
            $version = json_decode(file_get_contents(__DIR__.'/../../composer.json'), true);

            return sprintf('vector-php@%s', $version['version']);
        } catch (Throwable $e) {
            return sprintf('vector-php@unknown');
        }
    }
}
