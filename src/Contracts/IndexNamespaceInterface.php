<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\DataQuery;
use Upstash\Vector\DataQueryResult;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryResult;
use Upstash\Vector\VectorUpsert;

interface IndexNamespaceInterface
{
    public function getNamespaceInfo(): NamespaceInfo;

    public function reset(): void;

    public function delete(): void;

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

    public function queryData(DataQuery $query): DataQueryResult;
}
