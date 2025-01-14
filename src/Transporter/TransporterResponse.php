<?php

namespace Upstash\Vector\Transporter;

class TransporterResponse
{
    public function __construct(
        public int $statusCode,
        public ContentType $contentType,
        public Headers $headers = new Headers,
        public string $data = '',
    ) {}
}
