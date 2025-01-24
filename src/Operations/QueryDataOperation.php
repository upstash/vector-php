<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\DataQuery;
use Upstash\Vector\DataQueryResult;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorMatch;

/**
 * @internal
 */
final readonly class QueryDataOperation
{
    use AssertsApiResponseErrors;

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

    private function transformResponse(TransporterResponse $response): DataQueryResult
    {
        $data = json_decode($response->data, true);

        $results = array_map(function (array $result) {
            return new VectorMatch(
                id: $result['id'],
                score: $result['score'],
                vector: $result['vector'] ?? [],
                data: $result['data'] ?? '',
                metadata: $result['metadata'] ?? [],
            );
        }, $data['result'] ?? []);

        return new DataQueryResult($results);
    }
}
