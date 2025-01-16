<?php

namespace Upstash\Vector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Index;

class IndexTest extends TestCase
{
    public function test_can_be_initialized()
    {
        $index = new Index(
            url: 'https://relaxed-moose-10442-us1-vector.upstash.io',
            token: 'test-token',
        );

        $this->assertInstanceOf(Index::class, $index);
    }
}
