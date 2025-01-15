<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;

/**
 * @internal
 */
final readonly class FetchRandomVectorOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function fetch(): void
    {
        // TODO: Implement
    }
}
