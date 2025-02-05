<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;

/**
 * @internal
 */
final readonly class GetIndexInfoOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private TransporterInterface $transporter) {}

    public function getInfo(): IndexInfo
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: '/info',
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function transformResponse(TransporterResponse $response): IndexInfo
    {
        $data = json_decode($response->data, true);
        $result = $data['result'] ?? [];

        $namespaces = [];
        foreach ($result['namespaces'] as $namespace => $namespaceData) {
            $namespaces[$namespace] = new NamespaceInfo(
                vectorCount: $namespaceData['vectorCount'],
                pendingVectorCount: $namespaceData['pendingVectorCount'],
            );
        }

        return new IndexInfo(
            vectorCount: $result['vectorCount'],
            pendingVectorCount: $result['pendingVectorCount'],
            indexSize: $result['indexSize'],
            dimension: $result['dimension'],
            similarityFunction: $result['similarityFunction'],
            namespaces: $namespaces,
        );
    }
}
