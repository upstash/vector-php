<?php

namespace Upstash\Vector;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Traversable;
use Upstash\Vector\Contracts\Arrayable;

/**
 * @implements IteratorAggregate<int|string, VectorQueryResult>
 * @implements ArrayAccess<int|string, VectorQueryResult>
 */
final readonly class VectorQueryManyResult implements Arrayable, ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param  array<VectorQueryResult>  $results
     */
    public function __construct(private array $results) {}

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet(mixed $offset): VectorQueryResult
    {
        return $this->results[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void {}

    public function offsetUnset(mixed $offset): void {}

    public function count(): int
    {
        return count($this->results);
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->getResults());
    }

    /**
     * @return array<VectorQueryResult>
     */
    private function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return array{
     *     results: VectorQueryResult[]
     * }
     */
    public function toArray(): array
    {
        return [
            'results' => $this->results,
        ];
    }
}
