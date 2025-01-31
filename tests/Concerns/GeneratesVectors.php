<?php

namespace Upstash\Vector\Tests\Concerns;

use function Upstash\Vector\createRandomVector;

trait GeneratesVectors
{
    protected function generateVector(int $dimensions): array
    {
        return createRandomVector($dimensions);
    }
}
