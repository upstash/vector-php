<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class FetchRandomVectorTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_fetch_random_vector(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: [0.1, 0.1],
        ));
        $this->waitForIndex($this->namespace);

        // Act
        $result = $this->namespace->random();

        // Assert
        $this->assertNotNull($result);
        $this->assertSame('1', $result->id);
        $this->assertCount(2, $result->vector);
    }

    public function test_can_fetch_random_vector_when_index_is_empty(): void
    {
        // Act
        $result = $this->namespace->random();

        // Assert
        $this->assertNull($result);
    }
}
