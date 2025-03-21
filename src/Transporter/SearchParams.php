<?php

namespace Upstash\Vector\Transporter;

use Stringable;
use Upstash\Vector\Contracts\Arrayable;

final readonly class SearchParams implements Arrayable, Stringable
{
    /**
     * @param  array<string, string>  $queryParams
     */
    public function __construct(private array $queryParams = []) {}

    public function append(string $key, string $value): SearchParams
    {
        return new self([
            ...$this->queryParams,
            $key => $value,
        ]);
    }

    public function delete(string $key): SearchParams
    {
        return new self(
            array_filter($this->queryParams, fn ($k) => $k !== $key, ARRAY_FILTER_USE_KEY)
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->queryParams;
    }

    public function toString(): string
    {
        return http_build_query($this->queryParams);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function isEmpty(): bool
    {
        return count($this->queryParams) === 0;
    }
}
