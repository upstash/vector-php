<?php

namespace Upstash\Vector\Tests\Hybrid\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\GeneratesVectors;
use Upstash\Vector\Tests\Concerns\UsesHybridIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class UpsertVectorTest extends TestCase
{
    use GeneratesVectors;
    use UsesHybridIndex;
    use WaitsForIndex;

    public function test_upsert_vector(): void
    {
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $this->generateVector(384),
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(1, $info->vectorCount);
    }

    public function test_upsert_without_sparse_vector_throws_exception(): void
    {
        $this->expectException(OperationFailedException::class);
        $this->expectExceptionMessage('This index requires sparse vectors');

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $this->generateVector(384),
        ));
    }

    public function test_upsert_without_vector_throws_exception(): void
    {
        $this->expectException(OperationFailedException::class);
        $this->expectExceptionMessage('This index requires dense vectors');

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));
    }

    public function test_upsert_many_vectors(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: '1',
                vector: $this->generateVector(384),
                sparseVector: new SparseVector(
                    indices: [1, 2, 3],
                    values: [5, 6, 7],
                ),
            ),
            new VectorUpsert(
                id: '2',
                vector: $this->generateVector(384),
                sparseVector: new SparseVector(
                    indices: [4, 5, 6],
                    values: [8, 9, 10],
                ),
            ),
        ]);

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(2, $info->vectorCount);
    }
}
