<?php

namespace Upstash\Vector\Transporter;

readonly class TransporterRequest
{
    public function __construct(
        public ContentType $contentType,
        public Method $method,
        public string $path,
        public Headers $headers = new Headers,
        public array $data = [],
    ) {}
}
