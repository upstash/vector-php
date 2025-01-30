<?php

namespace Upstash\Vector\Tests\Hybrid\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\GeneratesVectors;
use Upstash\Vector\Tests\Concerns\UsesHybridIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpsert;

class FetchVectorsOperationTest extends TestCase
{
    use GeneratesVectors;
    use UsesHybridIndex;
    use WaitsForIndex;

    public function test_can_fetch_vectors_including_vectors(): void
    {
        // Arrange
        $vector = $this->generateVector(384);

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1'],
            includeVectors: true,
        ));

        // Assert
        $this->assertCount(384, $results[0]->vector);
        $this->assertSame([1, 2, 3], $results[0]->sparseVector->indices);
        $this->assertSame([5.0, 6.0, 7.0], $results[0]->sparseVector->values);
    }
}
