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
        $result = [
            'id' => $this->id,
            'data' => $this->data,
        ];

        if (! empty($this->metadata)) {
            $result['metadata'] = (object) $this->metadata;
        }

        return $result;
    }
}
