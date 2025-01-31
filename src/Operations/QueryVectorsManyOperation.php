<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Operations\Concerns\MapsVectorMatches;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryManyResult;
use Upstash\Vector\VectorQueryResult;

/**
 * @internal
 */
final readonly class QueryVectorsManyOperation
{
    use AssertsApiResponseErrors;
    use MapsVectorMatches;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    /**
     * @param  array<int|string,VectorQuery>  $queries
     */
    public function query(array $queries): VectorQueryManyResult
    {
        $queryKeys = array_keys($queries);
        $queries = array_values($queries);
        $data = array_map(fn (VectorQuery $query) => $query->toArray(), $queries);

        $path = $this->getPath();
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::POST,
            path: $path,
            data: $data,
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response, $queryKeys);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace !== '') {
            return "/query/$namespace";
        }

        return '/query';
    }

    private function transformResponse(TransporterResponse $response, array $queryKeys): VectorQueryManyResult
    {
        $data = json_decode($response->data, true);
        $result = $data['result'] ?? [];
        $result = array_combine($queryKeys, $result);
        $result = array_map(function (array $queryResult) {
            return new VectorQueryResult(results: array_map(function (array $vector) {
                return $this->mapVectorMatch($vector);
            }, $queryResult));
        }, $result);

        return new VectorQueryManyResult(results: $result);
    }
}
