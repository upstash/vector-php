<?php

namespace Upstash\Vector;

final readonly class VectorDeleteResult
{
    public function __construct(
        public int $deleted,
    ) {}
}
