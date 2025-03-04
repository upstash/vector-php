<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;

final readonly class VectorDeleteByMetadataFilter implements Arrayable
{
    public function __construct(
        public string $filter,
    ) {}

    /**
     * @return array{
     *     filter: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'filter' => $this->filter,
        ];
    }
}
