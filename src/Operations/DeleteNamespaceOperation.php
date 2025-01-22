<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;

/**
 * @internal
 */
final readonly class DeleteNamespaceOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function delete(): void
    {
        $namespace = trim($this->namespace);
        if ($namespace === '') {
            throw new OperationFailedException('The default namespace, which is the empty string "", cannot be deleted.');
        }

        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::DELETE,
            path: "/delete-namespace/$namespace",
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }
}
