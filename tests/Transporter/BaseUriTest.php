<?php

namespace Upstash\Vector\Tests\Transporter;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Transporter\BaseUri;

class BaseUriTest extends TestCase
{
    public function test_accepts_https_base_uri()
    {
        // Arrange
        $baseUri = new BaseUri('https://example.com');

        // Act
        $url = $baseUri->toString();

        // Assert
        $this->assertEquals('https://example.com/', $url);
    }

    public function test_accepts_http_base_uri()
    {
        // arrange
        $baseUri = new BaseUri('http://example.com');

        // Act
        $url = $baseUri->toString();

        // Assert
        $this->assertEquals('http://example.com/', $url);
    }

    public function test_accepts_base_uri_without_protocol()
    {
        // Arrange
        $baseUri = new BaseUri('example.com');

        // Act
        $url = $baseUri->toString();

        // Assert
        $this->assertEquals('https://example.com/', $url);
    }
}
