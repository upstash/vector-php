<?php

namespace Upstash\Vector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\DataUpsert;

class DataUpsertTest extends TestCase
{
    public function test_data_upsert_can_be_converted_to_array(): void
    {
        // Arrange
        $upsert = new DataUpsert(id: '1', data: 'test');

        // Act
        $data = $upsert->toArray();

        // Assert
        $this->assertSame([
            'id' => '1',
            'data' => 'test',
        ], $data);
    }

    public function test_metadata_is_only_set_if_not_empty(): void
    {
        // Arrange
        $upsert = new DataUpsert(id: '1', data: 'test');

        // Act
        $data = $upsert->toArray();

        // Assert
        $this->assertArrayNotHasKey('metadata', $data);
    }
}
