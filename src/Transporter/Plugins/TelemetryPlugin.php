<?php

namespace Upstash\Vector\Transporter\Plugins;

use Upstash\Vector\Contracts\TransporterPluginInterface;
use Upstash\Vector\Transporter\TransporterRequest;

readonly class TelemetryPlugin implements TransporterPluginInterface
{
    private string $runtime;

    public function __construct(
        private string $sdkVersion,
        ?string $runtime = '',
    ) {
        $this->runtime = $runtime ?? sprintf('php%s', phpversion());
    }

    public function expandRequest(TransporterRequest $request): TransporterRequest
    {
        $headers = $request->headers
            ->withHeader('Upstash-Telemetry-Runtime', $this->runtime)
            ->withHeader('Upstash-Telemetry-Sdk', $this->sdkVersion);

        return $request->withHeaders($headers);
    }
}
