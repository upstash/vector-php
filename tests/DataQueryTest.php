<?php

namespace Upstash\Vector\Tests;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\DataQuery;
use Upstash\Vector\Enums\FusionAlgorithm;
use Upstash\Vector\Enums\QueryMode;
use Upstash\Vector\Enums\WeightingStrategy;

class DataQueryTest extends TestCase
{
    public function test_maps_default_values_correctly(): void
    {
        // Arrange
        $query = new DataQuery(
            data: 'test',
        );

        // Act
        $data = $query->toArray();

        // Assert
        $this->assertSame([
            'data' => 'test',
            'topK' => 10,
            'includeMetadata' => false,
            'includeVectors' => false,
            'includeData' => false,
            'filter' => '',
            'queryMode' => QueryMode::HYBRID->value,
        ], $data);
    }

    public function test_maps_weighting_strategy_correctly(): void
    {
        // Arrange
        $query = new DataQuery(
            data: 'test',
            weightingStrategy: WeightingStrategy::INVERSE_DOCUMENT_FREQUENCY,
        );

        // Act
        $data = $query->toArray();

        // Assert
        $this->assertSame('IDF', $data['weightingStrategy']);
    }

    public function test_maps_fusion_algorithm_correctly(): void
    {
        // Arrange
        $query = new DataQuery(
            data: 'test',
            fusionAlgorithm: FusionAlgorithm::DISTRIBUTION_BASED_SCORE_FUSION,
        );

        // Act
        $data = $query->toArray();

        // Assert
        $this->assertSame('DBSF', $data['fusionAlgorithm']);
    }
}
