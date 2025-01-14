<?php

namespace Upstash\Vector;

final readonly class VectorUpsert
{
    public function __construct(
        public string $id,
        public array $vector = [],
        public array $metadata = [],
        public ?string $data = null,
    ) {}

    public function toArray(): array
    {
        // TODO: Improve transformation

        return [
            'id' => $this->id,
            'vector' => $this->vector,
            'metadata' => $this->metadata,
            'data' => $this->data,
        ];
    }
}
