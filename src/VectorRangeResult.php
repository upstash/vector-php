<?php

namespace Upstash\Vector;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Upstash\Vector\Contracts\Arrayable;
use Upstash\Vector\Operations\RangeVectorsOperation;

/**
 * @implements IteratorAggregate<int, VectorMatch>
 * @implements ArrayAccess<int, VectorMatch>
 */
final readonly class VectorRangeResult implements Arrayable, ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @param  array<VectorMatch>  $results
     */
    public function __construct(
        private array $results,
        public string $nextCursor,
        private VectorRange $originalRange,
        private RangeVectorsOperation $operation,
    ) {}

    public function count(): int
    {
        return count($this->results);
    }

    /**
     * @return array<VectorMatch>
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function next(?int $limit = null): VectorRangeResult
    {
        $range = new VectorRange(
            limit: $limit ?? $this->originalRange->limit,
            cursor: $this->nextCursor,
            includeMetadata: $this->originalRange->includeMetadata,
            includeVectors: $this->originalRange->includeVectors,
            includeData: $this->originalRange->includeData,
        );

        return $this->operation->range($range);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->results[$offset]);
    }

    public function offsetGet(mixed $offset): ?VectorMatch
    {
        if ($this->offsetExists($offset)) {
            return $this->results[$offset];
        }

        return null;
    }

    public function offsetSet(mixed $offset, mixed $value): void {}

    public function offsetUnset(mixed $offset): void {}

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->results);
    }

    /**
     * @return array{
     *     nextCursor: string,
     *     results: VectorMatch[]
     * }
     */
    public function toArray(): array
    {
        return [
            'nextCursor' => $this->nextCursor,
            'results' => $this->results,
        ];
    }
}
