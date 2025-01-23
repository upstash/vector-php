<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\IndexNamespaceInterface;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\DeleteNamespaceOperation;
use Upstash\Vector\Operations\DeleteVectorsOperation;
use Upstash\Vector\Operations\GetNamespaceInfoOperation;
use Upstash\Vector\Operations\QueryDataOperation;
use Upstash\Vector\Operations\QueryVectorsOperation;
use Upstash\Vector\Operations\ResetNamespaceOperation;
use Upstash\Vector\Operations\UpsertDataOperation;
use Upstash\Vector\Operations\UpsertVectorOperation;

final readonly class IndexNamespace implements IndexNamespaceInterface
{
    public function __construct(protected string $namespace, protected TransporterInterface $transporter) {}

    public function getNamespaceInfo(): NamespaceInfo
    {
        return (new GetNamespaceInfoOperation($this->namespace, $this->transporter))->getNamespaceInfo();
    }

    public function reset(): void
    {
        (new ResetNamespaceOperation($this->namespace, $this->transporter))->reset();
    }

    public function delete(): void
    {
        (new DeleteNamespaceOperation($this->namespace, $this->transporter))->delete();
    }

    public function upsert(VectorUpsert $vector): void
    {
        (new UpsertVectorOperation($this->namespace, $this->transporter))->upsert($vector);
    }

    /**
     * @param  array<VectorUpsert>  $vectors
     */
    public function upsertMany(array $vectors): void
    {
        (new UpsertVectorOperation($this->namespace, $this->transporter))->upsertMany($vectors);
    }

    public function upsertData(DataUpsert $data): void
    {
        (new UpsertDataOperation($this->namespace, $this->transporter))->upsert($data);
    }

    /**
     * @param  array<DataUpsert>  $data
     */
    public function upsertDataMany(array $data): void
    {
        (new UpsertDataOperation($this->namespace, $this->transporter))->upsertMany($data);
    }

    public function query(VectorQuery $query): VectorQueryResult
    {
        return (new QueryVectorsOperation($this->namespace, $this->transporter))->query($query);
    }

    public function queryData(DataQuery $query): DataQueryResult
    {
        return (new QueryDataOperation($this->namespace, $this->transporter))->query($query);
    }

    public function deleteVectors(array $ids): VectorDeleteResult
    {
        return (new DeleteVectorsOperation($this->namespace, $this->transporter))
            ->delete($ids);
    }
}
