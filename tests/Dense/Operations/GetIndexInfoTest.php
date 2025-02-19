<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\IndexType;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;

class GetIndexInfoTest extends TestCase
{
    use UsesDenseIndex;

    public function test_get_info(): void
    {
        $info = $this->index->getInfo();

        $this->assertInstanceOf(IndexInfo::class, $info);
        $this->assertSame(IndexType::DENSE, $info->indexType);
        $this->assertNull($info->sparseIndex);
        $this->assertNotNull($info->denseIndex);
        $this->assertSame(2, $info->denseIndex->dimension);
        $this->assertSame('COSINE', $info->denseIndex->similarityFunction);
    }
}
