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
use Upstash\Vector\VectorQueryResult;

/**
 * @internal
 */
final readonly class QueryVectorsOperation
{
    use AssertsApiResponseErrors;
    use MapsVectorMatches;

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

    private function transformResponse(TransporterResponse $response): VectorQueryResult
    {
        $data = json_decode($response->data, true);

        $results = array_map(fn (array $result) => $this->mapVectorMatch($result), $data['result'] ?? []);

        return new VectorQueryResult($results);
    }
}
