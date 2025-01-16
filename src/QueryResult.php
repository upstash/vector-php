<?php

namespace Upstash\Vector;

final readonly class QueryResult
{
    public function __construct(
        public string $id,
        public float $score,
        public array $vector = [],
        public string $data = '',
        public array $metadata = [],
    ) {}
}
