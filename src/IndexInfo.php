<?php

namespace Upstash\Vector;

final readonly class IndexInfo
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
    ) {}

    public function namespace(string $namespace): NamespaceInfo
    {
        $namespaceInfo = $this->namespaces[$namespace];
        if (! $namespaceInfo) {
            return new NamespaceInfo;
        }

        return $namespaceInfo;
    }
}
