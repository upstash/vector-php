<?php

namespace Upstash\Vector\Tests\Concerns;

trait GeneratesVectors
{
    protected function generateVector(int $dimensions): array
    {
        $vector = [];

        for ($i = 0; $i < $dimensions; $i++) {
            $vector[] = random_int(1, 100) / 100;
        }

        return $vector;
    }
}
