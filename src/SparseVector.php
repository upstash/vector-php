<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class SparseVector implements Arrayable
{
    /**
     * @param  array<int>  $indices
     * @param  array<float>  $values
     */
    public function __construct(public array $indices = [], public array $values = []) {}

    /**
     * @param  array<int>  $indices
     * @param  array<float>  $values
     */
    public static function of(array $indices = [], array $values = []): SparseVector
    {
        return new self($indices, $values);
    }

    /**
     * @return array{indices: array<int>, values: array<float>}
     */
    public function toArray(): array
    {
        return [
            'indices' => $this->indices,
            'values' => $this->values,
        ];
    }
}
