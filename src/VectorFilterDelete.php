<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Transformers\ToDeletablePayloadInterface;

final readonly class VectorFilterDelete implements ToDeletablePayloadInterface
{
    public function __construct(
        public string $filter,
    ) {}

    /**
     * @return array{
     *     filter: string
     * }
     */
    public function toDeletablePayload(): array
    {
        return [
            'filter' => $this->filter,
        ];
    }
}
