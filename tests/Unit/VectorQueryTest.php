<?php

namespace Upstash\Vector\Tests;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\FusionAlgorithm;
use Upstash\Vector\Enums\WeightingStrategy;
use Upstash\Vector\VectorQuery;

class VectorQueryTest extends TestCase
{
    public function test_maps_default_values_correctly(): void
    {
        // Arrange
        $query = new VectorQuery(
            vector: [1, 2, 3],
        );

        // Act
        $data = $query->toArray();

        // Assert
        $this->assertSame([
            'vector' => [1, 2, 3],
            'topK' => 10,
            'includeMetadata' => false,
            'includeVectors' => false,
            'includeData' => false,
            'filter' => '',
        ], $data);
    }

    public function test_maps_weighting_strategy_correctly(): void
    {
        // Arrange
        $query = new VectorQuery(
            vector: [1, 2, 3],
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
        $query = new VectorQuery(
            vector: [1, 2, 3],
            fusionAlgorithm: FusionAlgorithm::DISTRIBUTION_BASED_SCORE_FUSION,
        );

        // Act
        $data = $query->toArray();

        // Assert
        $this->assertSame('DBSF', $data['fusionAlgorithm']);
    }
}
