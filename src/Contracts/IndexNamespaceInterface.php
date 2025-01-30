<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\DataQuery;
use Upstash\Vector\DataQueryResult;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\VectorDeleteResult;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorFetchResult;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryManyResult;
use Upstash\Vector\VectorQueryResult;
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
     * @param  array<string|VectorIdentifierInterface>  $ids
     */
    public function delete(array $ids): VectorDeleteResult;

    public function fetch(VectorFetch $vectorFetch): VectorFetchResult;
}
