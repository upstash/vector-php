<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
class Headers
{
    public function __construct(private array $headers = []) {}

    public function withHeader(string $header, string $value): self
    {
        return new Headers([...$this->headers, $header => $value]);
    }

    public function toArray(): array
    {
        return $this->headers;
    }
}
