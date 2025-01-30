<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorUpsert;

class QueryVectorsTest extends TestCase
{
    use UsesSparseIndex;
    use WaitsForIndex;

    public function test_query_vectors(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: '1',
                sparseVector: new SparseVector(
                    indices: [1, 2, 3],
                    values: [5, 6, 7],
                ),
                data: 'Test Data',
            ),
        ]);

        $this->waitForIndex($this->namespace);

        $results = $this->namespace->query(new VectorQuery(
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
            topK: 1,
        ));

        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]->id);
    }

    public function test_query_vectors_including_vectors(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: '1',
                sparseVector: new SparseVector(
                    indices: [1, 2, 3],
                    values: [5, 6, 7],
                ),
            ),
        ]);

        $this->waitForIndex($this->namespace);

        $results = $this->namespace->query(new VectorQuery(
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
            topK: 1,
            includeVectors: true,
        ));

        $this->assertSame([1, 2, 3], $results[0]->sparseVector->indices);
        $this->assertSame([5.0, 6.0, 7.0], $results[0]->sparseVector->values);
    }
}
