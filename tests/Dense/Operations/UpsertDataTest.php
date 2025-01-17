<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\Tests\Concerns\UsesDenseIndexWithEmbedding;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;

class UpsertDataTest extends TestCase
{
    use UsesDenseIndexWithEmbedding;
    use WaitsForIndex;

    public function test_upsert_data(): void
    {
        $this->namespace->upsertData(new DataUpsert(
            id: '1',
            data: 'The capital of Japan is Tokyo',
        ));

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(1, $info->vectorCount);
    }

    public function test_upsert_many_data(): void
    {
        $this->namespace->upsertDataMany([
            new DataUpsert(id: '1', data: 'The capital of Japan is Tokyo'),
            new DataUpsert(id: '2', data: 'The capital of France is Paris'),
            new DataUpsert(id: '3', data: 'The capital of Germany is Berlin'),
        ]);

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(3, $info->vectorCount);
    }
}
