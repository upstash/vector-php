<?php

namespace Upstash\Vector;

/**
 * @return array<float>
 */
function createRandomVector(int $dimensions): array
{
    $vector = [];

    for ($i = 0; $i < $dimensions; $i++) {
        $vector[] = random_int(1, 100) / 100;
    }

    return $vector;
}
