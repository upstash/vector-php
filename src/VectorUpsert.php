<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorUpsert implements Arrayable
{
    /**
     * @param  array<float>  $vector
     * @param  array<string, mixed>  $metadata
     */
    public function __construct(
        public string $id,
        public array $vector = [],
        public ?SparseVector $sparseVector = null,
        public array $metadata = [],
        public ?string $data = null,
    ) {}

    /**
     * @return array{
     *     id: string,
     *     vector?: array<float>,
     *     sparse_vector?: array<string, float>,
     *     metadata?: \stdClass,
     *     data?: string,
     * }
     */
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
