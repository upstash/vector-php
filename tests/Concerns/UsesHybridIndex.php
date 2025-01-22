<?php

namespace Upstash\Vector\Tests\Concerns;

use Upstash\Vector\Contracts\IndexInterface;
use Upstash\Vector\Contracts\IndexNamespaceInterface;
use Upstash\Vector\Index;

trait UsesHybridIndex
{
    protected IndexInterface $index;

    protected IndexNamespaceInterface $namespace;

    public function setUp(): void
    {
        parent::setUp();

        $this->index = new Index(
            url: getenv('HYBRID_UPSTASH_VECTOR_REST_URL'),
            token: getenv('HYBRID_UPSTASH_VECTOR_REST_TOKEN'),
        );

        $this->namespace = $this->index->namespace(bin2hex(random_bytes(32)));
    }

    public function tearDown(): void
    {
        $this->namespace->delete();

        parent::tearDown();
    }
}
