<?php

namespace Upstash\Vector\Transporter;

readonly class TransporterRequest
{
    /**
     * @param  array<mixed>  $data
     */
    public function __construct(
        public ContentType $contentType,
        public Method $method,
        public string $path,
        public Headers $headers = new Headers,
        public array $data = [],
        public SearchParams $searchParams = new SearchParams,
    ) {}

    public function hasBody(): bool
    {
        return ! empty($this->data);
    }

    public function withHeaders(Headers $headers): self
    {
        return new self(
            contentType: $this->contentType,
            method: $this->method,
            path: $this->path,
            headers: $headers,
            data: $this->data,
            searchParams: $this->searchParams,
        );
    }
}
