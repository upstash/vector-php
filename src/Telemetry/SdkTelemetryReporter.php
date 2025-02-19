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
            ->withHeader('Upstash-Telemetry-Sdk', $this->getPackageVersion());
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
        return sprintf('vector-php@%s', SdkVersion::resolve());
    }
}
