<?php

namespace Upstash\Vector;

use Upstash\Vector\Enums\FusionAlgorithm;
use Upstash\Vector\Enums\QueryMode;
use Upstash\Vector\Enums\WeightingStrategy;

final readonly class DataQuery
{
    public function __construct(
        public string $data,
        public int $topK = 10,
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
        public string $filter = '',
        public ?WeightingStrategy $weightingStrategy = null,
        public ?FusionAlgorithm $fusionAlgorithm = null,
        public QueryMode $queryMode = QueryMode::HYBRID,
    ) {}

    public function toArray(): array
    {
        $data = [
            'data' => $this->data,
            'topK' => $this->topK,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
            'filter' => $this->filter,
            'queryMode' => $this->queryMode->value,
        ];

        if ($this->weightingStrategy !== null) {
            $data['weightingStrategy'] = $this->weightingStrategy->value;
        }

        if ($this->fusionAlgorithm !== null) {
            $data['fusionAlgorithm'] = $this->fusionAlgorithm->value;
        }

        return $data;
    }
}
