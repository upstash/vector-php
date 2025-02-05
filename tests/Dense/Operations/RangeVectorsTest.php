<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\MeasuresMemory;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorRange;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

class RangeVectorsTest extends TestCase
{
    use MeasuresMemory;
    use UsesDenseIndex;
    use WaitsForIndex;

    /**
     * @return array<VectorUpsert>
     */
    private function generateUpserts(int $count): array
    {
        $upserts = [];
        for ($i = 0; $i < $count; $i++) {
            $upserts[] = new VectorUpsert(
                id: (string) $i,
                vector: createRandomVector(2),
            );
        }

        return $upserts;
    }

    public function test_can_range_vectors(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->generateUpserts(100));
        $this->waitForIndex($this->namespace);

        $memory = $this->measureMemory(function () {
            // Act
            $results = $this->namespace->range(new VectorRange(limit: 10));

            // Assert
            $this->assertCount(10, $results);
        });

        // Assert
        $this->assertLessThan(1024 * 1024, $memory);
    }

    public function test_can_range_vectors_with_next_helper(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->generateUpserts(100));
        $this->waitForIndex($this->namespace);

        $memory = $this->measureMemory(function () {
            // Act
            $results = $this->namespace->range(new VectorRange(limit: 10));

            // Assert
            $this->assertCount(10, $results);

            // Act
            $results = $results->next(limit: 20);

            // Assert
            $this->assertCount(20, $results);
        });

        // Assert
        $this->assertLessThan(1024 * 1024, $memory);
    }

    public function test_can_range_vectors_using_next_cursor(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->generateUpserts(100));
        $this->waitForIndex($this->namespace);

        $memory = $this->measureMemory(function () {
            // Act
            $results = $this->namespace->range(new VectorRange(limit: 10));

            // Assert
            $this->assertCount(10, $results);

            // Act
            $results = $this->namespace->range(new VectorRange(limit: 20, cursor: $results->nextCursor));

            // Assert
            $this->assertCount(20, $results);
        });

        // Assert
        $this->assertLessThan(1024 * 1024, $memory);
    }

    public function test_can_range_vectors_using_iterator(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->generateUpserts(100));
        $this->waitForIndex($this->namespace);

        $memory = $this->measureMemory(function () {
            // Arrange
            $count = 0;

            // Act
            $results = $this->namespace->rangeIterator(new VectorRange(limit: 10));

            // Increment count
            foreach ($results as $result) {
                $count++;
            }

            // Second iteration tests rewind
            foreach ($results as $result) {
                $count++;
            }

            // Assert
            $this->assertSame(200, $count);
        });

        // Assert
        $this->assertLessThan(1024 * 1024, $memory);
    }

    public function test_can_range_vectors_using_iterator_can_break_loop(): void
    {
        // Arrange
        $this->namespace->upsertMany($this->generateUpserts(100));
        $this->waitForIndex($this->namespace);

        $memory = $this->measureMemory(function () {
            // Arrange
            $count = 0;

            // Act
            $results = $this->namespace->rangeIterator(new VectorRange(limit: 10));

            foreach ($results as $result) {
                $count++;
                if ($count === 25) {
                    break;
                }
            }

            // Assert
            $this->assertSame(25, $count);
        });

        // Assert
        $this->assertLessThan(1024 * 1024, $memory);
    }
}
