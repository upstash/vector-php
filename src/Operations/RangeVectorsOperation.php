<?php

namespace Upstash\Vector\Operations;

/**
 * @internal
 */
final readonly class RangeVectorsOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function range(): void
    {
        // TODO: Implement
    }
}
