<?php

namespace Upstash\Vector\Tests\Unit\Telemetry;

use PHPUnit\Framework\TestCase;
use Upstash\Vector\Telemetry\SdkTelemetryReporter;

class SdkTelemetryReporterTest extends TestCase
{
    public function test_runtime_is_correct(): void
    {
        $reporter = new SdkTelemetryReporter;
        $version = phpversion();

        $runtime = $reporter->getRuntime();

        $this->assertSame("php$version", $runtime);
    }

    public function test_package_version_is_correct(): void
    {
        $reporter = new SdkTelemetryReporter;
        $version = json_decode(file_get_contents(__DIR__.'/../../../composer.json'), true)['version'];

        $packageVersion = $reporter->getPackageVersion();

        $this->assertSame("vector-php@$version", $packageVersion);
    }
}
