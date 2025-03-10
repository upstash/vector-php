<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\IndexNamespaceInterface;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Iterators\VectorRangeIterator;
use Upstash\Vector\Operations\DeleteNamespaceOperation;
use Upstash\Vector\Operations\DeleteVectorsOperation;
use Upstash\Vector\Operations\FetchRandomVectorOperation;
use Upstash\Vector\Operations\FetchVectorsOperation;
use Upstash\Vector\Operations\GetNamespaceInfoOperation;
use Upstash\Vector\Operations\QueryDataOperation;
use Upstash\Vector\Operations\QueryVectorsManyOperation;
use Upstash\Vector\Operations\QueryVectorsOperation;
use Upstash\Vector\Operations\RangeVectorsOperation;
use Upstash\Vector\Operations\ResetNamespaceOperation;
use Upstash\Vector\Operations\UpdateVectorOperation;
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

    public function deleteNamespace(): void
    {
        (new DeleteNamespaceOperation($this->namespace, $this->transporter))->delete();
    }

    public function upsert(VectorUpsert $vector): void
    {
        (new UpsertVectorOperation($this->namespace, $this->transporter))->upsert($vector);
    }

    public function upsertMany(array $vectors): void
    {
        (new UpsertVectorOperation($this->namespace, $this->transporter))->upsertMany($vectors);
    }

    public function upsertData(DataUpsert $data): void
    {
        (new UpsertDataOperation($this->namespace, $this->transporter))->upsert($data);
    }

    public function upsertDataMany(array $data): void
    {
        (new UpsertDataOperation($this->namespace, $this->transporter))->upsertMany($data);
    }

    public function query(VectorQuery $query): VectorQueryResult
    {
        return (new QueryVectorsOperation($this->namespace, $this->transporter))->query($query);
    }

    public function queryMany(array $queries): VectorQueryManyResult
    {
        return (new QueryVectorsManyOperation($this->namespace, $this->transporter))->query($queries);
    }

    public function queryData(DataQuery $query): DataQueryResult
    {
        return (new QueryDataOperation($this->namespace, $this->transporter))->query($query);
    }

    /**
     * @param  string[]|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter  $ids
     */
    public function delete(array|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter $ids): VectorDeleteResult
    {
        return (new DeleteVectorsOperation($this->namespace, $this->transporter))
            ->delete($ids);
    }

    public function fetch(VectorFetch|VectorFetchByPrefix $vectorFetch): VectorFetchResult
    {
        return (new FetchVectorsOperation($this->namespace, $this->transporter))
            ->fetch($vectorFetch);
    }

    public function random(): ?VectorMatch
    {
        return (new FetchRandomVectorOperation($this->namespace, $this->transporter))->fetch();
    }

    public function update(VectorUpdate $update): void
    {
        (new UpdateVectorOperation($this->namespace, $this->transporter))->update($update);
    }

    public function range(VectorRange $range): VectorRangeResult
    {
        return (new RangeVectorsOperation($this->namespace, $this->transporter))->range($range);
    }

    public function rangeIterator(VectorRange $range): VectorRangeIterator
    {
        return (new RangeVectorsOperation($this->namespace, $this->transporter))->rangeIterator($range);
    }
}
