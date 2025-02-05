<?php

namespace Upstash\Vector\Operations\Concerns;

use Upstash\Vector\SparseVector;
use Upstash\Vector\VectorMatch;

trait MapsVectorMatches
{
    /**
     * @param  array<mixed>  $result
     */
    private function mapVectorMatch(array $result): VectorMatch
    {
        $vector = [];
        if (isset($result['vector'])) {
            $vector = $result['vector'];
        }

        $sparseVector = new SparseVector;
        if (isset($result['sparseVector'])) {
            ['indices' => $indices, 'values' => $values] = $result['sparseVector'];
            $sparseVector = new SparseVector(indices: $indices, values: $values);
        }

        return new VectorMatch(
            id: $result['id'],
            score: $result['score'] ?? 0,
            vector: $vector,
            sparseVector: $sparseVector,
            data: $result['data'] ?? '',
            metadata: $result['metadata'] ?? [],
        );
    }
}
