<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class UpsertVectorTest extends TestCase
{
    use UsesSparseIndex;
    use WaitsForIndex;

    public function test_upsert_vector(): void
    {
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            sparseVector: new SparseVector(
                indices: [0, 1],
                values: [1, 2],
            ),
        ));
        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(1, $info->vectorCount);
    }

    public function test_upsert_many_vectors(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', sparseVector: new SparseVector(
                indices: [0, 1],
                values: [1, 2],
            )),
            new VectorUpsert(id: '2', sparseVector: new SparseVector(
                indices: [2, 3],
                values: [4, 5],
            )),
        ]);

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(2, $info->vectorCount);
    }
}
