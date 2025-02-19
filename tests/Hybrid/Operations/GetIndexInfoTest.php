<?php

namespace Upstash\Vector\Tests\Hybrid\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Enums\IndexType;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\Tests\Concerns\UsesHybridIndex;

class GetIndexInfoTest extends TestCase
{
    use UsesHybridIndex;

    public function test_get_info(): void
    {
        $info = $this->index->getInfo();

        $this->assertInstanceOf(IndexInfo::class, $info);
        $this->assertSame(IndexType::HYBRID, $info->indexType);
        $this->assertNotNull($info->sparseIndex);
        $this->assertNotNull($info->denseIndex);
    }
}
