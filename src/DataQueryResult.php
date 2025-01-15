<?php

namespace Upstash\Vector;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class DataQueryResult implements Countable, IteratorAggregate
{
    /**
     * @param  array<Vector>  $results
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
     * @return Vector[]
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
