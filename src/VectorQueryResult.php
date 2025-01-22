<?php

namespace Upstash\Vector;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int,QueryResult>
 * @implements ArrayAccess<int,QueryResult>
 */
final readonly class VectorQueryResult implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param  array<QueryResult>  $results
     */
    public function __construct(
        private array $results,
    ) {}

    public function count(): int
    {
        return count($this->results);
    }

    /**
     * @return Traversable<int,QueryResult>
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->getResults());
    }

    /**
     * @return QueryResult[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet(mixed $offset): QueryResult
    {
        return $this->results[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {}

    public function offsetUnset(mixed $offset): void {}
}
