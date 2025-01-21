<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;
use Upstash\Vector\Tests\Concerns\WaitsForIndex;

class UpsertDataTest extends TestCase
{
    use UsesSparseIndex;
    use WaitsForIndex;

    public function test_upsert_data(): void
    {
        $this->namespace->upsertData(new DataUpsert('1', 'The capital of Japan is Tokyo'));

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(1, $info->vectorCount);
    }

    public function test_upsert_many_data(): void
    {
        $this->namespace->upsertDataMany([
            new DataUpsert('1', 'The capital of Japan is Tokyo'),
            new DataUpsert('2', 'The capital of France is Paris'),
            new DataUpsert('3', 'The capital of Germany is Berlin'),
        ]);

        $this->waitForIndex($this->namespace);

        $info = $this->namespace->getNamespaceInfo();

        $this->assertSame(3, $info->vectorCount);
    }
}
