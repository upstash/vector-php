<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorDelete;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

class DeleteVectorsOperationTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_delete_vectors(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert('id-1', vector: createRandomVector(2)),
            new VectorUpsert('id-2', vector: createRandomVector(2)),
            new VectorUpsert('id-3', vector: createRandomVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        $result = $this->namespace->delete([
            'id-1',
            'id-2',
        ]);

        $this->assertEquals(2, $result->deleted);
        $info = $this->namespace->getNamespaceInfo();
        $this->assertSame(1, $info->vectorCount);
    }

    public function test_delete_vectors_from_a_query_result_results(): void
    {
        $vector = createRandomVector(2);
        $this->namespace->upsertMany([
            new VectorUpsert('id-1', $vector),
            new VectorUpsert('id-2', vector: createRandomVector(2)),
            new VectorUpsert('id-3', vector: createRandomVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        $queryResult = $this->namespace->query(new VectorQuery(
            vector: $vector,
            topK: 2,
        ));

        $result = $this->namespace->delete($queryResult->getResults());

        $this->assertEquals(2, $result->deleted);
    }

    public function test_delete_vectors_using_builder_pattern(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert('users:1', vector: createRandomVector(2)),
            new VectorUpsert('users:2', vector: createRandomVector(2)),
            new VectorUpsert('posts:1', vector: createRandomVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        $result = $this->namespace->delete(VectorDelete::fromIds(['users:1', 'users:2']));

        $this->assertEquals(2, $result->deleted);
        $this->assertEquals(1, $this->namespace->getNamespaceInfo()->vectorCount);
    }

    public function test_delete_vectors_using_an_id_prefix(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert('users:1', vector: createRandomVector(2)),
            new VectorUpsert('users:2', vector: createRandomVector(2)),
            new VectorUpsert('posts:1', vector: createRandomVector(2)),
        ]);
        $this->waitForIndex($this->namespace);

        $result = $this->namespace->delete(VectorDelete::fromPrefix('users:'));

        $this->assertEquals(2, $result->deleted);
        $this->assertEquals(1, $this->namespace->getNamespaceInfo()->vectorCount);
    }

    public function test_delete_vectors_using_a_metadata_filter(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: 'users:1',
                vector: createRandomVector(2),
                metadata: [
                    'salary' => 1000,
                ],
            ),
            new VectorUpsert(
                id: 'users:2',
                vector: createRandomVector(2),
                metadata: [
                    'salary' => 2000,
                ],
            ),
            new VectorUpsert(
                id: 'users:3',
                vector: createRandomVector(2),
                metadata: [
                    'salary' => 3000,
                ],
            ),
        ]);
        $this->waitForIndex($this->namespace);

        $result = $this->namespace->delete(VectorDelete::fromMetadataFilter('salary < 3000'));

        $this->assertEquals(2, $result->deleted);
        $this->assertEquals(1, $this->namespace->getNamespaceInfo()->vectorCount);
    }
}
