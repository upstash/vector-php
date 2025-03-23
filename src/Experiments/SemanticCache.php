<?php

namespace Upstash\Vector\Experiments;

use Upstash\Vector\DataQuery;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\IndexNamespace;

readonly class SemanticCache
{
    public function __construct(
        private IndexNamespace $index,
        public float $minScore = 0.95,
    ) {
        //
    }

    public function get(string $key): ?string
    {
        $result = $this->index->queryData(new DataQuery(
            data: $key,
            topK: 1,
            includeMetadata: true,
        ));

        if ($result->count() === 0) {
            return null;
        }

        $result = $result->offsetGet(0);
        if ($result->score < $this->minScore) {
            return null;
        }

        $value = $result->metadata['value'];
        if ($value === null) {
            return null;
        }

        return $value;
    }

    /**
     * @param  string|array<string>  $keys
     */
    public function set(string|array $keys, string $value): void
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $upserts = array_map(fn ($key) => new DataUpsert(
            id: md5($key),
            data: $key,
            metadata: ['value' => $value],
        ), $keys);

        $this->index->upsertDataMany($upserts);
    }

    /**
     * @param  string|array<string>  $keys
     */
    public function delete(string|array $keys): void
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $this->index->delete(
            ids: array_map(fn ($key) => md5($key), $keys),
        );
    }

    public function clear(): void
    {
        $this->index->reset();
    }
}
