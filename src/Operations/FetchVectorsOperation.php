<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorFetch;
use Upstash\Vector\VectorFetchResult;
use Upstash\Vector\VectorMatch;

/**
 * @internal
 */
final readonly class FetchVectorsOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function fetch(VectorFetch $vectorFetch): VectorFetchResult
    {
        $path = $this->getPath();
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: $path,
            data: $vectorFetch->toArray(),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace === '') {
            return '/fetch';
        }

        return "/fetch/$namespace";
    }

    private function transformResponse(TransporterResponse $response): VectorFetchResult
    {
        $data = json_decode($response->data, true)['result'] ?? [];
        $results = array_map(function (array $result) {
            return new VectorMatch(
                id: $result['id'],
                score: 1.0,
                vector: $result['vector'] ?? [],
                data: $result['data'] ?? '',
                metadata: $result['metadata'] ?? [],
            );
        }, $data);

        return new VectorFetchResult($results);
    }
}
