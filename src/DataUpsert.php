<?php

namespace Upstash\Vector;

final readonly class DataUpsert
{
    public function __construct(
        public string $id,
        public string $data,
        public array $metadata = [],
    ) {}

    public function toArray(): array
    {
        // TODO: Improve transformation
        return [
            'id' => $this->id,
            'data' => $this->data,
        ];
    }
}
