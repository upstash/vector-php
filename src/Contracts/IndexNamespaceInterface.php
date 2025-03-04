<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\DataQuery;
use Upstash\Vector\DataQueryResult;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\Iterators\VectorRangeIterator;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\VectorDeleteByMetadataFilter;
use Upstash\Vector\VectorDeleteByPrefix;
use Upstash\Vector\VectorDeleteResult;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorFetchResult;
use Upstash\Vector\VectorMatch;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryManyResult;
use Upstash\Vector\VectorQueryResult;
use Upstash\Vector\VectorRange;
use Upstash\Vector\VectorRangeResult;
use Upstash\Vector\VectorUpdate;
use Upstash\Vector\VectorUpsert;

interface IndexNamespaceInterface
{
    public function getNamespaceInfo(): NamespaceInfo;

    public function reset(): void;

    public function deleteNamespace(): void;

    public function upsert(VectorUpsert $vector): void;

    /**
     * @param  array<VectorUpsert>  $vectors
     */
    public function upsertMany(array $vectors): void;

    public function upsertData(DataUpsert $data): void;

    /**
     * @param  array<DataUpsert>  $data
     */
    public function upsertDataMany(array $data): void;

    public function query(VectorQuery $query): VectorQueryResult;

    /**
     * @param  array<VectorQuery>  $queries
     */
    public function queryMany(array $queries): VectorQueryManyResult;

    public function queryData(DataQuery $query): DataQueryResult;

    /**
     * @param  array<string|VectorIdentifierInterface>|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter  $ids
     */
    public function delete(array|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter $ids): VectorDeleteResult;

    public function fetch(VectorFetch $vectorFetch): VectorFetchResult;

    public function random(): ?VectorMatch;

    public function update(VectorUpdate $update): void;

    public function range(VectorRange $range): VectorRangeResult;

    public function rangeIterator(VectorRange $range): VectorRangeIterator;
}
