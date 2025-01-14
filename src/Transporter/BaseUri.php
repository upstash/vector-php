<?php

namespace Upstash\Vector\Transporter;

/**
 * @internal
 */
readonly class BaseUri
{
    public function __construct(private string $baseUri) {}

    public function toString(): string
    {
        $baseUri = $this->baseUri;
        if (str_ends_with($baseUri, '/')) {
            $baseUri = substr($baseUri, 0, -1);
        }

        foreach (['http://', 'https://'] as $protocol) {
            if (str_starts_with($baseUri, $protocol)) {
                return "{$baseUri}/";
            }
        }

        return "https://{$baseUri}/";
    }
}
