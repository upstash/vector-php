<?php

namespace Upstash\Vector;

final readonly class Vector
{
    public function __construct(
        public string $id,
        public float $score,
        public array $vectors = [],
        public string $data = '',
        public array $metadata = [],
    ) {}
}
