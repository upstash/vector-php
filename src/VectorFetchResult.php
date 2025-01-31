<?php

namespace Upstash\Vector;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int,VectorMatch>
 * @implements ArrayAccess<int,VectorMatch>
 */
final readonly class VectorFetchResult implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param  array<VectorMatch>  $results
     */
    public function __construct(
        public array $results,
    ) {}

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet(mixed $offset): VectorMatch
    {
        return $this->results[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {}

    public function offsetUnset(mixed $offset): void {}

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->results);
    }

    /**
     * @return array<VectorMatch>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function count(): int
    {
        return count($this->results);
    }
}
