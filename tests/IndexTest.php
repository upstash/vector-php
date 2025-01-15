<?php

namespace Upstash\Vector\Tests;

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

    public function test_can_be_initialized_from_environment()
    {
        $index = Index::fromEnv();

        $this->assertInstanceOf(Index::class, $index);
    }
}
