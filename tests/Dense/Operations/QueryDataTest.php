<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\DataQuery;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\Tests\Concerns\UsesDenseIndexWithEmbedding;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;

class QueryDataTest extends TestCase
{
    use UsesDenseIndexWithEmbedding;
    use WaitsForIndex;

    public function test_query_data(): void
    {
        $this->namespace->upsertDataMany([
            new DataUpsert(
                id: '1',
                data: 'The capital of Japan is Tokyo',
            ),
            new DataUpsert(
                id: '2',
                data: 'The capital of France is Paris',
            ),
            new DataUpsert(
                id: '3',
                data: 'The capital of Germany is Berlin',
            ),
        ]);

        $this->waitForIndex($this->namespace);

        $results = $this->namespace->queryData(new DataQuery(
            data: 'What is the capital of France?',
            topK: 1,
        ));

        $this->assertCount(1, $results);
        $this->assertEquals('2', $results[0]->id);
    }
}
