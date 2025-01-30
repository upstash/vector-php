<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpsert;

class FetchVectorsTest extends TestCase
{
    use UsesSparseIndex;
    use WaitsForIndex;

    public function test_fetch_vectors_including_vectors(): void
    {
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));
        $this->waitForIndex($this->namespace);

        $results = $this->namespace->fetch(new VectorFetch(
            ids: ['1'],
            includeVectors: true,
        ));

        $this->assertSame([1, 2, 3], $results[0]->sparseVector->indices);
        $this->assertSame([5.0, 6.0, 7.0], $results[0]->sparseVector->values);

    }
}
