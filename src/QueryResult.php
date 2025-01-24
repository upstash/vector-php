<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\VectorIdentifierInterface;

final readonly class QueryResult implements VectorIdentifierInterface
{
    public function __construct(
        public string $id,
        public float $score,
        public array $vector = [],
        public string $data = '',
        public array $metadata = [],
    ) {}

    public function getIdentifier(): string
    {
        return $this->id;
    }
}
