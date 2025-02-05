<?php

namespace Upstash\Vector\Tests\Concerns;

use Upstash\Vector\Contracts\IndexInterface;
use Upstash\Vector\Contracts\IndexNamespaceInterface;
use Upstash\Vector\Index;

trait UsesSparseIndex
{
    protected IndexInterface $index;

    protected IndexNamespaceInterface $namespace;

    public function setUp(): void
    {
        parent::setUp();

        $url = getenv('SPARSE_UPSTASH_VECTOR_REST_URL');
        if (! $url) {
            throw new \Exception('SPARSE_UPSTASH_VECTOR_REST_URL is not set');
        }

        $token = getenv('SPARSE_UPSTASH_VECTOR_REST_TOKEN');
        if (! $token) {
            throw new \Exception('SPARSE_UPSTASH_VECTOR_REST_TOKEN is not set');
        }

        $this->index = new Index(
            url: $url,
            token: $token,
        );

        $this->namespace = $this->index->namespace(bin2hex(random_bytes(32)));
    }

    public function tearDown(): void
    {
        $this->namespace->deleteNamespace();

        parent::tearDown();
    }
}
