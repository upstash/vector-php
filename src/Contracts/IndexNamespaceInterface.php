<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\DataUpsert;
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
}
