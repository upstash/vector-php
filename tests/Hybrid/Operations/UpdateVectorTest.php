<?php

namespace Upstash\Vector\Tests\Hybrid\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\UpdateMode;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Tests\Concerns\UsesHybridIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorUpdate;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

class UpdateVectorTest extends TestCase
{
    use UsesHybridIndex;
    use WaitsForIndex;

    public function test_can_update_vector(): void
    {
        // Arrange
        $sparseVector = new SparseVector(
            indices: [1, 2, 3],
            values: [0.1, 0.2, 0.3],
        );

        $this->namespace->upsertMany([
            new VectorUpsert('1', vector: createRandomVector(dimensions: 384), sparseVector: $sparseVector),
            new VectorUpsert('2', vector: createRandomVector(dimensions: 384), sparseVector: $sparseVector),
            new VectorUpsert('3', vector: createRandomVector(dimensions: 384), sparseVector: $sparseVector),
            new VectorUpsert('4', vector: createRandomVector(dimensions: 384), sparseVector: $sparseVector),
            new VectorUpsert('5', vector: createRandomVector(dimensions: 384), sparseVector: $sparseVector),
        ]);

        $this->waitForIndex($this->namespace);

        $updatedVector = createRandomVector(dimensions: 384);

        // Act
        $this->namespace->update(new VectorUpdate(
            id: '1',
            vector: $updatedVector,
            sparseVector: new SparseVector(
                indices: [2, 3, 4],
                values: [0.6, 0.6, 0.6],
            ),
        ));

        // Assert
        $result = $this->namespace->fetch(new VectorFetch(['1'], includeVectors: true));
        $this->assertEquals(1, $result->count());
        $this->assertEquals($updatedVector, $result->offsetGet(0)->vector);
        $this->assertEquals([2, 3, 4], $result->offsetGet(0)->sparseVector->indices);
        $this->assertEquals([0.6, 0.6, 0.6], $result->offsetGet(0)->sparseVector->values);
    }

    public function test_can_update_vector_override_metadata(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: createRandomVector(dimensions: 384),
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [0.1, 0.2, 0.3],
            ),
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
        $this->assertEquals(['foo' => 'baz'], $result->offsetGet(0)->metadata);
    }

    public function test_can_update_vector_patch_metadata(): void
    {
        // Arrange
        $this->namespace->upsert(new VectorUpsert(
            id: '1',
            vector: createRandomVector(dimensions: 384),
            sparseVector: new SparseVector(
                indices: [1, 2, 3],
                values: [0.1, 0.2, 0.3],
            ),
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
        $this->assertEquals(['foo' => 'baz', 'baz' => 'qux'], $result->offsetGet(0)->metadata);
    }
}
