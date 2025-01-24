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
final readonly class DataQueryResult implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param  array<VectorMatch>  $results
     */
    public function __construct(
        private array $results,
    ) {}

    public function count(): int
    {
        return count($this->results);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->getResults());
    }

    /**
     * @return VectorMatch[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

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
}
