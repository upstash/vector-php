<?php

namespace Upstash\Vector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\VectorUpsert;

class VectorUpsertTest extends TestCase
{
    public function test_vector_upsert_can_be_converted_to_array(): void
    {
        // Arrange
        $upsert = new VectorUpsert(id: '1', vector: [1, 2]);

        // Act
        $data = $upsert->toArray();

        // Assert
        $this->assertSame([
            'id' => '1',
            'vector' => [1, 2],
        ], $data);
    }

    public function test_metadata_is_only_set_if_not_empty(): void
    {
        // Arrange
        $upsert = new VectorUpsert(id: '1');

        // Act
        $data = $upsert->toArray();

        // Assert
        $this->assertArrayNotHasKey('metadata', $data);
    }
}
