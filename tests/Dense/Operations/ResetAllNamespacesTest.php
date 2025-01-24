<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\ParatestAware;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class ResetAllNamespacesTest extends TestCase
{
    use ParatestAware;
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_reset_all_namespaces(): void
    {
        if ($this->runningInParatest()) {
            $this->markTestSkipped('This test is not supported in Paratest');
        }

        // Arrange
        $this->index->upsertMany([
            new VectorUpsert(id: '1', vector: [1, 2]),
            new VectorUpsert(id: '2', vector: [4, 5]),
            new VectorUpsert(id: '3', vector: [7, 8]),
        ]);
        $this->waitForIndex($this->index);

        // Act
        $this->index->resetAll();

        // Assert
        $this->assertSame(0, $this->index->getInfo()->vectorCount);
    }
}
