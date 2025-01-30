<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\GeneratesVectors;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorUpsert;

class QueryVectorsManyTest extends TestCase
{
    use GeneratesVectors;
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_query_index(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: '1',
                vector: [0.1, 0.1],
                metadata: [
                    'country' => 'US',
                    'continent' => 'NA',
                ],
                data: 'Los Angeles',
            ),
            new VectorUpsert(
                id: '2',
                vector: [0.2, 0.2],
                metadata: [
                    'country' => 'PT',
                    'continent' => 'EU',
                ],
                data: 'Lisbon',
            ),
            new VectorUpsert(
                id: '3',
                vector: [0.3, 0.3],
                metadata: [
                    'country' => 'DE',
                    'continent' => 'EU',
                ],
                data: 'Berlin',
            ),
        ]);
        $this->waitForIndex($this->namespace);

        $results = $this->namespace->queryMany([
            new VectorQuery(
                vector: [0.6, 0.3],
                topK: 1,
                includeVectors: true,
            ),
            new VectorQuery(
                vector: [0.2, 0.2],
                topK: 2,
                includeMetadata: true,
            ),
        ]);

        $this->assertCount(2, $results);
        $this->assertCount(1, $results[0]);
        $this->assertCount(2, $results[1]);
    }

    public function test_can_query_index_with_query_names(): void
    {
        $this->namespace->upsertMany([
            new VectorUpsert(
                id: '1',
                vector: [0.1, 0.1],
                metadata: [
                    'country' => 'US',
                    'continent' => 'NA',
                ],
                data: 'Los Angeles',
            ),
            new VectorUpsert(
                id: '2',
                vector: [0.2, 0.2],
                metadata: [
                    'country' => 'PT',
                    'continent' => 'EU',
                ],
                data: 'Lisbon',
            ),
            new VectorUpsert(
                id: '3',
                vector: [0.3, 0.3],
                metadata: [
                    'country' => 'DE',
                    'continent' => 'EU',
                ],
                data: 'Berlin',
            ),
        ]);
        $this->waitForIndex($this->namespace);

        $results = $this->namespace->queryMany([
            'query1' => new VectorQuery(
                vector: [0.1, 0.1],
                topK: 1,
            ),
            'query2' => new VectorQuery(
                vector: [0.2, 0.2],
                topK: 2,
            ),
        ]);

        $this->assertCount(2, $results);

        $this->assertCount(1, $results['query1']);
        $this->assertCount(2, $results['query2']);
    }
}
