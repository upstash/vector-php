<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
readonly class Uri implements \Stringable
{
    public function __construct(private BaseUri $baseUri, private string $path = '', private ?SearchParams $searchParams = null) {}

    public function withPath(string $path): self
    {
        return new Uri($this->baseUri, $path);
    }

    public function withSearchParams(SearchParams $searchParams): self
    {
        return new Uri($this->baseUri, $this->path, $searchParams);
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

        $url = "$baseUrl/$path";

        if ($this->searchParams === null || $this->searchParams->isEmpty()) {
            return $url;
        }

        $queryString = $this->searchParams->toString();

        return "$baseUrl/$path?$queryString";
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
