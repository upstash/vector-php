<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Exceptions\WrongIndexDimensionsException;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\VectorUpsert;

class UpsertVectorTest extends TestCase
{
    use UsesDenseIndex;

    public function test_upsert_vector(): void
    {
        // Act
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: [1, 2],
        ));

        // Assert
        $this->assertSame(1, $this->namespace->getNamespaceInfo()->vectorCount);
    }

    public function test_upsert_many_vectors(): void
    {
        // Act
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', vector: [1, 2]),
            new VectorUpsert(id: '2', vector: [4, 5]),
            new VectorUpsert(id: '3', vector: [7, 8]),
        ]);

        // Assert
        $this->assertSame(3, $this->namespace->getNamespaceInfo()->vectorCount);
    }

    public function test_upsert_vector_with_different_dimensions_than_index_throws_exception(): void
    {
        // Assert
        $this->expectException(WrongIndexDimensionsException::class);

        // Act
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: [1, 2, 3],
        ));
    }
}
