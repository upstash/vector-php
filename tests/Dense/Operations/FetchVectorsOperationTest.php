<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\GeneratesVectors;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpsert;

class FetchVectorsOperationTest extends TestCase
{
    use GeneratesVectors;
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_fetch_vectors(): void
    {
        // Arrange
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', vector: $this->generateVector(2)),
            new VectorUpsert(id: '2', vector: $this->generateVector(2)),
            new VectorUpsert(id: '3', vector: $this->generateVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1', '2'],
            includeVectors: true,
        ));

        // Assert
        $this->assertCount(2, $results);
        $this->assertCount(2, $results[0]->vector);
    }
}
