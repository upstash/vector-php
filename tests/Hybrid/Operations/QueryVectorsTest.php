<?php

namespace Upstash\Vector\Tests\Hybrid\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesHybridIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

class QueryVectorsTest extends TestCase
{
    use UsesHybridIndex;
    use WaitsForIndex;

    public function test_query_vectors(): void
    {
        $vector = createRandomVector(384);

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));

        $this->waitForIndex($this->namespace);

        $vectors = $this->namespace->query(new VectorQuery(
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
            topK: 1,
        ));

        $this->assertCount(1, $vectors);
        $this->assertSame('1', $vectors[0]->id);
    }

    public function test_query_with_no_vectors(): void
    {
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: createRandomVector(384),
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));

        $this->waitForIndex($this->namespace);

        $vectors = $this->namespace->query(new VectorQuery(
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
            topK: 1,
        ));

        $this->assertCount(1, $vectors);
        $this->assertSame('1', $vectors[0]->id);
    }

    public function test_query_with_no_sparse_vectors(): void
    {
        $vector = createRandomVector(384);

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));

        $this->waitForIndex($this->namespace);

        $vectors = $this->namespace->query(new VectorQuery(
            vector: $vector,
            topK: 1,
        ));

        $this->assertCount(1, $vectors);
        $this->assertSame('1', $vectors[0]->id);
    }

    public function test_query_vectors_including_vectors(): void
    {
        $vector = createRandomVector(384);

        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
        ));

        $this->waitForIndex($this->namespace);

        $vectors = $this->namespace->query(new VectorQuery(
            vector: $vector,
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [5, 6, 7],
            ),
            topK: 1,
            includeVectors: true,
        ));

        $this->assertSame([1, 2, 3], $vectors[0]->sparseVector->indices);
        $this->assertSame([5.0, 6.0, 7.0], $vectors[0]->sparseVector->values);
        $this->assertCount(384, $vectors[0]->vector);
    }
}
