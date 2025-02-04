<?php

namespace Upstash\Vector\Tests\Unit\Telemetry;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Telemetry\SdkVersion;

class SdkVersionTest extends TestCase
{
    public function test_version_is_known(): void
    {
        $version = SdkVersion::resolve();

        $this->assertNotSame(SdkVersion::UNKNOWN, $version);
    }
}
