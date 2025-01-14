<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;

/**
 * @internal
 */
final readonly class ResetNamespaceOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function reset(): void
    {
        $path = '/reset';
        if (trim($this->namespace) !== '') {
            $path = "/reset/$path";
        }

        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::DELETE,
            path: $path,
        );

        $response = $this->transporter->sendRequest($request);

        // TODO: Assert errors and throw exceptions
    }
}
