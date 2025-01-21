<?php

namespace Upstash\Vector;

final readonly class SparseVector
{
    /**
     * @param  array<int>  $indices
     * @param  array<float>  $values
     */
    public function __construct(public array $indices = [], public array $values = []) {}

    public static function of(array $indices = [], array $values = []): SparseVector
    {
        return new self($indices, $values);
    }

    public function toArray(): array
    {
        return [
            'indices' => $this->indices,
            'values' => $this->values,
        ];
    }
}
