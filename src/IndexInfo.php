<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Arrayable;
use Upstash\Vector\Enums\IndexType;

final readonly class IndexInfo implements Arrayable
{
    /**
     * @param  array<string, NamespaceInfo>  $namespaces
     */
    public function __construct(
        public int $vectorCount = 0,
        public int $pendingVectorCount = 0,
        public int $indexSize = 0,
        public int $dimension = 0,
        public string $similarityFunction = '',
        public array $namespaces = [],
        public IndexType $indexType = IndexType::UNKNOWN,
        public ?DenseIndexInfo $denseIndex = null,
        public ?SparseIndexInfo $sparseIndex = null,
    ) {}

    public function namespace(string $namespace): NamespaceInfo
    {
        return $this->namespaces[$namespace] ?? new NamespaceInfo;
    }

    /**
     * @return array{
     *     indexSize: int,
     *     dimension: int,
     *     similarityFunction: string,
     *     namespaces: array<string, NamespaceInfo>
     * }
     */
    public function toArray(): array
    {
        return [
            'indexSize' => $this->indexSize,
            'dimension' => $this->dimension,
            'similarityFunction' => $this->similarityFunction,
            'namespaces' => $this->namespaces,
            'indexType' => $this->indexType->value,
            'denseIndex' => $this->denseIndex?->toArray(),
            'sparseIndex' => $this->sparseIndex?->toArray(),
        ];
    }
}
