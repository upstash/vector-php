<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\SparseVector;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorMatch;
use Upstash\Vector\VectorQuery;
use Upstash\Vector\VectorQueryResult;

/**
 * @internal
 */
final readonly class QueryVectorsOperation
{
    use AssertsApiResponseErrors;

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

        $results = array_map(function (array $result) {
            $vector = [];
            if (isset($result['vector'])) {
                $vector = $result['vector'];
            }

            $sparseVector = new SparseVector;
            if (isset($result['sparseVector'])) {
                ['indices' => $indices, 'values' => $values] = $result['sparseVector'];
                $sparseVector = new SparseVector(indices: $indices, values: $values);
            }

            return new VectorMatch(
                id: $result['id'],
                score: $result['score'],
                vector: $vector,
                sparseVector: $sparseVector,
                data: $result['data'] ?? '',
                metadata: $result['metadata'] ?? [],
            );
        }, $data['result'] ?? []);

        return new VectorQueryResult($results);
    }
}
