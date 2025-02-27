<?php

namespace Upstash\Vector;

use Http\Discovery\Psr18ClientDiscovery;
use Upstash\Vector\Contracts\IndexInterface;
use Upstash\Vector\Contracts\IndexNamespaceInterface;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Exceptions\MissingEnvironmentVariableException;
use Upstash\Vector\Iterators\VectorRangeIterator;
use Upstash\Vector\Operations\GetIndexInfoOperation;
use Upstash\Vector\Operations\ListNamespacesOperation;
use Upstash\Vector\Operations\ResetAllNamespacesOperation;
use Upstash\Vector\Transporter\BaseUri;
use Upstash\Vector\Transporter\Headers;
use Upstash\Vector\Transporter\HttpTransporter;

final class Index implements IndexInterface
{
    public function __construct(
        private readonly string $url,
        #[\SensitiveParameter] private readonly string $token,
        private ?TransporterInterface $transporter = null,
    ) {}

    public static function fromEnv(): self
    {
        $url = getenv('UPSTASH_VECTOR_REST_URL');
        if (! $url) {
            throw new MissingEnvironmentVariableException('UPSTASH_VECTOR_REST_URL');
        }

        $token = getenv('UPSTASH_VECTOR_REST_TOKEN');
        if (! $token) {
            throw new MissingEnvironmentVariableException('UPSTASH_VECTOR_REST_TOKEN');
        }

        return new self(url: $url, token: $token);
    }

    public function namespace(string $namespace): IndexNamespaceInterface
    {
        return new IndexNamespace($namespace, $this->getTransporter());
    }

    public function getInfo(): IndexInfo
    {
        return (new GetIndexInfoOperation($this->getTransporter()))->getInfo();
    }

    public function getNamespaceInfo(): NamespaceInfo
    {
        return $this->namespace('')->getNamespaceInfo();
    }

    public function reset(): void
    {
        $this->namespace('')->reset();
    }

    protected function getTransporter(): TransporterInterface
    {
        if ($this->transporter) {
            return $this->transporter;
        }

        return $this->transporter = new HttpTransporter(
            client: Psr18ClientDiscovery::find(),
            baseUri: new BaseUri($this->url),
            headers: new Headers([
                'Authorization' => "Bearer {$this->token}",
            ])
        );
    }

    public function deleteNamespace(): void
    {
        $this->namespace('')->deleteNamespace();
    }

    public function upsert(VectorUpsert $vector): void
    {
        $this->namespace('')->upsert($vector);
    }

    public function upsertMany(array $vectors): void
    {
        $this->namespace('')->upsertMany($vectors);
    }

    public function upsertData(DataUpsert $data): void
    {
        $this->namespace('')->upsertData($data);
    }

    public function upsertDataMany(array $data): void
    {
        $this->namespace('')->upsertDataMany($data);
    }

    public function query(VectorQuery $query): VectorQueryResult
    {
        return $this->namespace('')->query($query);
    }

    public function queryMany(array $queries): VectorQueryManyResult
    {
        return $this->namespace('')->queryMany($queries);
    }

    public function queryData(DataQuery $query): DataQueryResult
    {
        return $this->namespace('')->queryData($query);
    }

    public function delete(array $ids): VectorDeleteResult
    {
        return $this->namespace('')->delete($ids);
    }

    public function fetch(VectorFetch $vectorFetch): VectorFetchResult
    {
        return $this->namespace('')->fetch($vectorFetch);
    }

    public function resetAll(): void
    {
        (new ResetAllNamespacesOperation($this->getTransporter()))->resetAll();
    }

    public function random(): ?VectorMatch
    {
        return $this->namespace('')->random();
    }

    public function update(VectorUpdate $update): void
    {
        $this->namespace('')->update($update);
    }

    public function listNamespaces(): array
    {
        return (new ListNamespacesOperation($this->getTransporter()))->list();
    }

    public function range(VectorRange $range): VectorRangeResult
    {
        return $this->namespace('')->range($range);
    }

    public function rangeIterator(VectorRange $range): VectorRangeIterator
    {
        return $this->namespace('')->rangeIterator($range);
    }

    public function deleteUsingIdPrefix(string $prefix): VectorDeleteResult
    {
        return $this->namespace('')->deleteUsingIdPrefix($prefix);
    }

    public function deleteUsingMetadataFilter(string $filter): VectorDeleteResult
    {
        return $this->namespace('')->deleteUsingMetadataFilter($filter);
    }
}
