<?php

namespace Upstash\Vector\Transporter;

class TransporterResponse
{
    public function __construct(
        public int $statusCode,
        public string $contentType,
        public Headers $headers = new Headers,
        public string $data = '',
    ) {}
}
