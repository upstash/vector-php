<?php

namespace Upstash\Vector\Tests\Unit\Transporter;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Transporter\SearchParams;

class SearchParamsTest extends TestCase
{
    public function test_search_params_can_be_serialized_to_string(): void
    {
        $params = new SearchParams([
            'limit' => 10,
            'offset' => 20,
        ]);

        $queryString = $params->toString();

        $this->assertSame('limit=10&offset=20', $queryString);
    }

    public function test_search_params_can_be_appended(): void
    {
        $params = new SearchParams([
            'limit' => 10,
            'offset' => 20,
        ]);

        $params = $params->append('foo', 'bar');

        $queryString = $params->toString();

        $this->assertSame('limit=10&offset=20&foo=bar', $queryString);
    }

    public function test_search_params_can_be_deleted(): void
    {
        $params = new SearchParams([
            'limit' => 10,
            'offset' => 20,
        ]);

        $params = $params->delete('limit');

        $queryString = $params->toString();

        $this->assertSame('offset=20', $queryString);
    }
}
