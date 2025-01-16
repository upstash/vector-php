<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorUpsert;

class QueryVectorTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    /**
     * @return array<VectorUpsert>
     */
    private function getSampleVectors(): array
    {
        return [
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
        ];
    }

    public function test_can_query_index(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->getSampleVectors());
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->query(new VectorQuery(
            vector: [0.1, 0.1],
            topK: 1,
        ));

        // Assert
        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]->id);
        $this->assertSame([], $results[0]->vector);
        $this->assertSame([], $results[0]->metadata);
        $this->assertSame('', $results[0]->data);
    }

    public function test_query_with_filters(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->getSampleVectors());
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->query(new VectorQuery(
            vector: [0.1, 0.1],
            filter: 'continent = "EU"',
        ));

        // Assert
        $this->assertCount(2, $results);
    }

    public function test_query_includes_vector(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->getSampleVectors());
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->query(new VectorQuery(
            vector: [0.1, 0.1],
            topK: 1,
            includeVectors: true,
        ));

        // Assert
        $this->assertCount(1, $results);
        $this->assertEquals([0.1, 0.1], $results[0]->vector);
    }

    public function test_query_includes_metadata(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->getSampleVectors());
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->query(new VectorQuery(
            vector: [0.1, 0.1],
            topK: 1,
            includeMetadata: true,
        ));

        // Assert
        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]->id);
        $this->assertSame('NA', $results[0]->metadata['continent']);
    }

    public function test_query_includes_data(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->getSampleVectors());
        $this->waitForIndex($this->namespace);

        // Act
        $results = $this->namespace->query(new VectorQuery(
            vector: [0.1, 0.1],
            topK: 1,
            includeData: true,
        ));

        // Assert
        $this->assertCount(1, $results);
        $this->assertEquals('1', $results[0]->id);
        $this->assertSame('Los Angeles', $results[0]->data);
    }
}
