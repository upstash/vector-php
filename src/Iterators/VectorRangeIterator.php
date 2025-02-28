<?php

namespace Upstash\Vector\Iterators;

use Iterator;
use Upstash\Vector\Operations\RangeVectorsOperation;
use Upstash\Vector\VectorMatch;
use Upstash\Vector\VectorRange;
use Upstash\Vector\VectorRangeResult;

/**
 * @implements \Iterator<string, VectorMatch>
 */
class VectorRangeIterator implements Iterator
{
    private string $nextCursor;

    private int $position = 0;

    /**
     * @var VectorMatch[]
     */
    private array $results = [];

    public function __construct(
        private readonly RangeVectorsOperation $operation,
        private VectorRange $range,
    ) {
        $rangeResult = $this->operation->range($range);
        $this->nextCursor = $rangeResult->nextCursor;
        $this->results = $rangeResult->getResults();
    }

    public function current(): VectorMatch
    {
        return $this->results[$this->position];
    }

    public function next(): void
    {
        $this->position++;

        if ($this->position >= count($this->results) && $this->nextCursor !== '') {
            $rangeResult = $this->fetchWithCursor($this->nextCursor);

            $this->nextCursor = $rangeResult->nextCursor;
            $this->results = $rangeResult->getResults();
            $this->position = 0;
        }
    }

    public function key(): string
    {
        return $this->current()->getIdentifier();
    }

    public function valid(): bool
    {
        if ($this->nextCursor === '' && $this->position >= count($this->results)) {
            return false;
        }

        return true;
    }

    public function rewind(): void
    {
        $rangeResult = $this->fetchWithCursor('0');
        $this->nextCursor = $rangeResult->nextCursor;
        $this->position = 0;
        $this->results = $rangeResult->getResults();
    }

    private function fetchWithCursor(string $cursor): VectorRangeResult
    {
        return $this->operation->range(new VectorRange(
            limit: $this->range->limit,
            cursor: $cursor,
            prefix: $this->range->prefix,
            includeMetadata: $this->range->includeMetadata,
            includeVectors: $this->range->includeVectors,
            includeData: $this->range->includeData,
        ));
    }
}
