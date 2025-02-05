<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class DataUpsert implements Arrayable
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public string $id,
        public string $data,
        public array $metadata = [],
    ) {}

    /**
     * @return array<string, mixed>
     */
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
