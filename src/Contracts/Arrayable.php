<?php

namespace Upstash\Vector\Contracts;

interface Arrayable
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
