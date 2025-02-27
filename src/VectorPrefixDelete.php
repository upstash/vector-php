<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Transformers\ToDeletablePayloadInterface;

final readonly class VectorPrefixDelete implements ToDeletablePayloadInterface
{
    public function __construct(public string $prefix) {}

    /**
     * @return array{
     *     prefix: string
     * }
     */
    public function toDeletablePayload(): array
    {
        return [
            'prefix' => $this->prefix,
        ];
    }
}
