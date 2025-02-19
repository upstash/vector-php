<?php

namespace Upstash\Vector\Tests\Sparse\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\IndexType;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\Tests\Concerns\UsesSparseIndex;

class GetIndexInfoTest extends TestCase
{
    use UsesSparseIndex;

    public function test_get_info(): void
    {
        $info = $this->index->getInfo();

        $this->assertInstanceOf(IndexInfo::class, $info);
        $this->assertSame(IndexType::SPARSE, $info->indexType);
        $this->assertNotNull($info->sparseIndex);
        $this->assertNull($info->denseIndex);
        $this->assertSame('BM25', $info->sparseIndex->embeddingModel);
    }
}
