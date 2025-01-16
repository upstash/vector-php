<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorUpsert;

class GetNamespaceInfoTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_get_info_on_empty_namespace(): void
    {
        $info = $this->namespace->getNamespaceInfo();

        $this->assertInstanceOf(NamespaceInfo::class, $info);
    }

    public function test_get_info_on_namespace_that_doesnt_exist(): void
    {
        $namespace = $this->index->namespace('doesnt-exist');

        $info = $namespace->getNamespaceInfo();

        $this->assertInstanceOf(NamespaceInfo::class, $info);
        $this->assertSame(0, $info->vectorCount);
    }

    public function test_get_info_on_namespace_with_several_vectors(): void
    {
        // Arrange
        $this->namespace->upsertMany([
            new VectorUpsert(id: '1', vector: [1, 2]),
            new VectorUpsert(id: '2', vector: [4, 5]),
            new VectorUpsert(id: '3', vector: [7, 8]),
        ]);
        $this->waitForIndex($this->namespace);

        // Act
        $info = $this->namespace->getNamespaceInfo();

        // Assert
        $this->assertInstanceOf(NamespaceInfo::class, $info);
        $this->assertSame(3, $info->vectorCount);
    }
}
