<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

class FetchVectorsOperationTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_fetch_vectors(): void
    {
        // Arrange
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', vector: createRandomVector(2)),
            new VectorUpsert(id: '2', vector: createRandomVector(2)),
            new VectorUpsert(id: '3', vector: createRandomVector(2)),
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

    public function test_can_fetch_vectors_and_reference_them_by_vector_id(): void
    {
        // Arrange
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', vector: createRandomVector(2)),
            new VectorUpsert(id: '2', vector: createRandomVector(2)),
            new VectorUpsert(id: '3', vector: createRandomVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1', '2'],
            includeVectors: true,
        ));

        // Assert
        $this->assertCount(2, $results);
        $this->assertArrayHasKey('1', $results);
        $this->assertCount(2, $results['1']->vector);
    }

    public function test_can_fetch_vectors_that_dont_exist(): void
    {
        // Act
        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1', '2'],
            includeVectors: true,
        ));

        // Assert
        $this->assertCount(0, $results);
    }

    public function test_can_fetch_vectors_that_dont_exist_and_get_null(): void
    {
        // Act
        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1', '2'],
            includeVectors: true,
        ));

        // Assert
        $this->assertNull($results[0]);
        $this->assertNull($results['1']);
    }
}
