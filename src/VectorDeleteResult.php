<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorDeleteResult implements Arrayable
{
    public function __construct(
        public int $deleted,
    ) {}

    /**
     * @return array{
     *     deleted: int
     * }
     */
    public function toArray(): array
    {
        return [
            'deleted' => $this->deleted,
        ];
    }
}
