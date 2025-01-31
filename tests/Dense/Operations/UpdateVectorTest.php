<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\UpdateMode;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpdate;
use Upstash\Vector\VectorUpsert;

class UpdateVectorTest extends TestCase
{
    use UsesDenseIndex;
    use WaitsForIndex;

    public function test_can_update_vector(): void
    {
        // Arrange
        $this->namespace->upsertMany([
            new VectorUpsert('1', [0.1, 0.1]),
            new VectorUpsert('2', [0.2, 0.2]),
            new VectorUpsert('3', [0.3, 0.3]),
            new VectorUpsert('4', [0.4, 0.4]),
            new VectorUpsert('5', [0.5, 0.5]),
        ]);

        $this->waitForIndex($this->namespace);

        // Act
        $this->namespace->update(new VectorUpdate('1', [0.6, 0.6]));

        // Assert
        $result = $this->namespace->fetch(new VectorFetch(['1'], includeVectors: true));
        $this->assertEquals(1, $result->count());
        $this->assertEquals([0.6, 0.6], $result->offsetGet(0)->vector);
    }

    public function test_can_update_vector_override_metadata(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: [0.1, 0.1],
            metadata: ['foo' => 'bar', 'baz' => 'qux'],
        ));

        $this->waitForIndex($this->namespace);

        // Act
        $this->namespace->update(new VectorUpdate(
            id: '1',
            metadata: ['foo' => 'baz'],
            metadataUpdateMode: UpdateMode::OVERWRITE,
        ));

        // Assert
        $result = $this->namespace->fetch(new VectorFetch(['1'], includeMetadata: true, includeVectors: true));
        $this->assertEquals(1, $result->count());
        $this->assertEquals([0.1, 0.1], $result->offsetGet(0)->vector);
        $this->assertEquals(['foo' => 'baz'], $result->offsetGet(0)->metadata);
    }

    public function test_can_update_vector_patch_metadata(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: [0.1, 0.1],
            metadata: ['foo' => 'bar', 'baz' => 'qux'],
        ));

        $this->waitForIndex($this->namespace);

        // Act
        $this->namespace->update(new VectorUpdate(
            id: '1',
            metadata: ['foo' => 'baz'],
            metadataUpdateMode: UpdateMode::PATCH,
        ));

        // Assert
        $result = $this->namespace->fetch(new VectorFetch(['1'], includeMetadata: true, includeVectors: true));
        $this->assertEquals(1, $result->count());
        $this->assertEquals([0.1, 0.1], $result->offsetGet(0)->vector);
        $this->assertEquals(['foo' => 'baz', 'baz' => 'qux'], $result->offsetGet(0)->metadata);
    }
}
