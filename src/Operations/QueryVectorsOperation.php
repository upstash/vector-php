<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryResult;

/**
 * @internal
 */
final readonly class QueryVectorsOperation
{
    public function __construct(
        private string $namespace,
        private TransporterInterface $transporter,
    ) {}

    public function query(VectorQuery $query): VectorQueryResult
    {
        $namespace = trim($this->namespace);
        $path = '/query';
        if ($namespace !== '') {
            $path = "/query/$namespace";
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

    private function assertResponse(TransporterResponse $response)
    {
        // TODO: Assert errors and throw exceptions
    }

    private function transformResponse(TransporterResponse $response): VectorQueryResult
    {
        return new VectorQueryResult;
    }
}
