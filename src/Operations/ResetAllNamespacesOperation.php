<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\SearchParams;
use Upstash\Vector\Transporter\TransporterRequest;

final readonly class ResetAllNamespacesOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private TransporterInterface $transporter) {}

    public function resetAll(): void
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::DELETE,
            path: '/reset',
            searchParams: new SearchParams(['all' => 'true']),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }
}
