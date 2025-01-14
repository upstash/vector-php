<?php

namespace Upstash\Vector\Operations;

use InvalidArgumentException;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;

/**
 * @internal
 */
final readonly class DeleteNamespaceOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function delete(): void
    {
        $namespace = trim($this->namespace);
        if ($namespace === '') {
            // TODO: Improve exception
            throw new InvalidArgumentException('The default namespace, which is the empty string "", cannot be deleted.');
        }

        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::DELETE,
            path: "/delete-namespace/$namespace",
        );

        $response = $this->transporter->sendRequest($request);

        // TODO: Assert errors and throw exceptions
    }
}
