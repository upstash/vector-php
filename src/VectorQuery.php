<?php

namespace Upstash\Vector;

use Upstash\Vector\Enums\FusionAlgorithm;
use Upstash\Vector\Enums\WeightingStrategy;

final readonly class VectorQuery
{
    /**
     * @param  array<float>  $vector
     */
    public function __construct(
        public array $vector,
        public int $topK = 10,
        public bool $includeMetadata = false,
        public bool $includeVectors = false,
        public bool $includeData = false,
        public string $filter = '',
        public ?WeightingStrategy $weightingStrategy = null,
        public ?FusionAlgorithm $fusionAlgorithm = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'vector' => $this->vector,
            'topK' => $this->topK,
            'includeMetadata' => $this->includeMetadata,
            'includeVectors' => $this->includeVectors,
            'includeData' => $this->includeData,
            'filter' => $this->filter,
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
