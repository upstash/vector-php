<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\DataQuery;
use Upstash\Vector\DataQueryResult;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;

/**
 * @internal
 */
final readonly class QueryDataOperation
{
    public function __construct(
        private string $namespace,
        private TransporterInterface $transporter,
    ) {}

    public function query(DataQuery $query): DataQueryResult
    {
        $namespace = trim($this->namespace);
        $path = '/query-data';
        if ($namespace !== '') {
            $path = "/query-data/$namespace";
        }

        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::POST,
            path: $path,
            data: $query->toArray(),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function assertResponse(TransporterResponse $response): void
    {
        // TODO: Assert response
    }

    private function transformResponse(TransporterResponse $response): DataQueryResult
    {
        return new DataQueryResult;
    }
}
