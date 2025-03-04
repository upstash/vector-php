<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
readonly class Headers
{
    /**
     * @param  array<string, string>  $headers
     */
    public function __construct(private array $headers = []) {}

    public function withHeader(string $header, string $value): self
    {
        return new Headers([...$this->headers, $header => $value]);
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
