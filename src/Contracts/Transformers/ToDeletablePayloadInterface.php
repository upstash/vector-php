<?php

namespace Upstash\Vector\Contracts\Transformers;

interface ToDeletablePayloadInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toDeletablePayload(): array;
}
