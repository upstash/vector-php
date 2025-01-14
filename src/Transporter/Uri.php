<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
readonly class Uri
{
    public function __construct(private BaseUri $baseUri, private string $path = '') {}

    public function withPath(string $path): self
    {
        return new Uri($this->baseUri, $path);
    }

    public function toString(): string
    {
        $baseUrl = $this->baseUri->toString();
        if (str_ends_with($baseUrl, '/')) {
            $baseUrl = substr($baseUrl, 0, -1);
        }

        $path = $this->path;
        if (str_starts_with($path, '/')) {
            $path = substr($path, 1);
        }

        return "$baseUrl/$path";
    }
}
