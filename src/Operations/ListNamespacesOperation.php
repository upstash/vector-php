<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;

/**
 * @internal
 */
final readonly class ListNamespacesOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private TransporterInterface $transporter) {}

    public function list(): array
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: '/list-namespaces',
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function transformResponse(TransporterResponse $response): array
    {
        $data = json_decode($response->data, true);

        return $data['result'] ?? [];
    }
}
