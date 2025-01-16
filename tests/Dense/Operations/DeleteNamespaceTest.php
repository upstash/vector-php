<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class DeleteNamespaceTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_cannot_delete_default_namespace(): void
    {
        // Assert
        $this->expectException(OperationFailedException::class);
        $this->expectExceptionMessage('The default namespace, which is the empty string "", cannot be deleted.');

        // Act
        $this->index->delete();
    }

    public function test_can_delete_namespace(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert('1', [1, 2]));
        $this->waitForIndex($this->index);

        // Act
        $this->namespace->delete();

        // Assert
        $this->assertSame(0, $this->namespace->getNamespaceInfo()->vectorCount);
    }
}
