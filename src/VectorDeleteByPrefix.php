<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorDeleteByPrefix implements Arrayable
{
    public function __construct(
        public string $prefix,
    ) {}

    /**
     * @return array{
     *     prefix: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'prefix' => $this->prefix,
        ];
    }
}
