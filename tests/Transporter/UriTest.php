<?php

namespace Upstash\Vector\Tests\Transporter;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Transporter\BaseUri;
use Upstash\Vector\Transporter\Uri;

class UriTest extends TestCase
{
    public function test_works_with_empty_path()
    {
        // Arrange
        $uri = new Uri(new BaseUri('https://example.com'));

        // Assert
        $this->assertEquals('https://example.com/', $uri->toString());
    }

    public function test_can_append_path()
    {
        // Arrange
        $uri = new Uri(new BaseUri('https://example.com'));

        // Act
        $newUri = $uri->withPath('/test');

        // Assert
        $this->assertEquals('https://example.com/test', $newUri->toString());
    }

    public function test_can_append_path_without_slash()
    {
        // Arrange
        $uri = new Uri(new BaseUri('https://example.com'));

        // Act
        $newUri = $uri->withPath('test');

        // Assert
        $this->assertEquals('https://example.com/test', $newUri->toString());
    }
}
