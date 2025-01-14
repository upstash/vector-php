<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\IndexInfo;
use Upstash\Vector\NamespaceInfo;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;

/**
 * @internal
 */
final readonly class GetIndexInfoOperation
{
    public function __construct(private TransporterInterface $transporter) {}

    public function getInfo(): IndexInfo
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: '/info',
        );

        $response = $this->transporter->sendRequest($request);

        $data = json_decode($response->data, true);

        return $this->transformDataToIndexInfo($data['result']);
    }

    private function transformDataToIndexInfo(array $data): IndexInfo
    {
        $namespaces = [];

        foreach ($data['namespaces'] as $namespace => $namespaceData) {
            $namespaces[$namespace] = new NamespaceInfo(
                vectorCount: $namespaceData['vectorCount'],
                pendingVectorCount: $namespaceData['pendingVectorCount'],
            );
        }

        return new IndexInfo(
            vectorCount: $data['vectorCount'],
            pendingVectorCount: $data['pendingVectorCount'],
            indexSize: $data['indexSize'],
            dimension: $data['dimension'],
            similarityFunction: $data['similarityFunction'],
            namespaces: $namespaces,
        );
    }
}
