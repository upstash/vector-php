<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class ResetNamespaceTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_reset_namespace(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');

        // Arrange
        $this->namespace->upsert(new VectorUpsert('1', [0.1, 0.1]));
        $this->waitForIndex($this->index);

        // Act
        $this->namespace->reset();

        // Assert
        $this->assertSame(0, $this->namespace->getNamespaceInfo()->vectorCount);
    }
}
