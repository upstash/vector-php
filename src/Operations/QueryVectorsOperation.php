<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;

/**
 * @internal
 */
final readonly class QueryVectorsOperation
{
    public function __construct(
        private string $namespace,
        private TransporterInterface $transporter,
    ) {}

    public function query(): void {}
}
