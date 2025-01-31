<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class FetchRandomVectorTest extends TestCase
{
    use UsesSparseIndex;
    use WaitsForIndex;

    public function test_can_fetch_random_vector(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5.0, 6.0, 7.0],
            ),
        ));
        $this->waitForIndex($this->namespace);

        // Act
        $result = $this->namespace->random();

        // Assert
        $this->assertNotNull($result);
        $this->assertSame('1', $result->id);
        $this->assertSame([1, 2, 3], $result->sparseVector->indices);
        $this->assertSame([5.0, 6.0, 7.0], $result->sparseVector->values);
    }

    public function test_can_fetch_random_vector_when_index_is_empty(): void
    {
        // Act
        $result = $this->namespace->random();

        // Assert
        $this->assertNull($result);
    }
}
