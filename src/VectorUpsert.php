<?php

namespace Upstash\Vector;

final readonly class VectorUpsert
{
    public function __construct(
        public string $id,
        public array $vector = [],
        public ?SparseVector $sparseVector = null,
        public array $metadata = [],
        public ?string $data = null,
    ) {}

    public function toArray(): array
    {
        $result = [
            'id' => $this->id,
        ];

        if (! empty($this->metadata)) {
            $result['metadata'] = (object) $this->metadata;
        }

        if ($this->sparseVector !== null) {
            $result['sparseVector'] = $this->sparseVector->toArray();
        }

        if (! empty($this->vector)) {
            $result['vector'] = $this->vector;
        }

        if ($this->data !== null) {
            $result['data'] = $this->data;
        }

        return $result;
    }
}
