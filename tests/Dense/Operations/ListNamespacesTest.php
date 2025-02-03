<?php

namespace Upstash\Vector\Tests\Dense\Operations;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Tests\Concerns\UsesDenseIndex;

class ListNamespacesTest extends TestCase
{
    use UsesDenseIndex;

    public function test_can_list_namespaces(): void
    {
        $namespaces = $this->index->listNamespaces();

        $this->assertGreaterThanOrEqual(1, $namespaces);
        $this->assertContains('', $namespaces);
    }
}
