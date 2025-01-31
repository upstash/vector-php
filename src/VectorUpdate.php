<?php

namespace Upstash\Vector;

use Upstash\Vector\Enums\UpdateMode;

final readonly class VectorUpdate
{
    /**
     * @param  array<float>|null  $vector
     */
    public function __construct(
        public string $id,
        public ?array $vector = null,
        public ?SparseVector $sparseVector = null,
        public ?string $data = null,
        public ?array $metadata = null,
        public UpdateMode $metadataUpdateMode = UpdateMode::OVERWRITE,
    ) {}

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
        ];

        if ($this->vector !== null) {
            $data['vector'] = $this->vector;
        }

        if ($this->sparseVector !== null) {
            $data['sparseVector'] = $this->sparseVector->toArray();
        }

        if ($this->data !== null) {
            $data['data'] = $this->data;
        }

        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
            $data['metadataUpdateMode'] = $this->metadataUpdateMode->value;
        }

        return $data;
    }
}
