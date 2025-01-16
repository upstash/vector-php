<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;

class GetInfoTest extends TestCase
{
    use UsesDenseIndex;

    public function test_get_info(): void
    {
        $info = $this->index->getInfo();

        $this->assertInstanceOf(IndexInfo::class, $info);
    }
}
