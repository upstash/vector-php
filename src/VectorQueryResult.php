<?php

namespace Upstash\Vector;

use Countable;
use IteratorAggregate;
use Traversable;

final readonly class VectorQueryResult implements Countable, IteratorAggregate
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
}
