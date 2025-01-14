<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\DataUpsert;

/**
 * @internal
 */
final readonly class UpsertDataOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function upsert(DataUpsert $upsert): void
    {
        $request = $this->createRequest($upsert->toArray());
        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    public function upsertMany(array $upsert): void
    {
        $data = array_map(fn (DataUpsert $upsert) => $upsert->toArray(), $upsert);
        $request = $this->createRequest($data);

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    private function createRequest(array $data): TransporterRequest
    {
        $namespace = trim($this->namespace);
        $path = '/upsert-data';
        if ($namespace !== '') {
            $path = "/upsert-data/$namespace";
        }

        return new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::POST,
            path: $path,
            data: $data,
        );
    }

    private function assertResponse(TransporterResponse $response): void
    {
        if ($response->statusCode === 422) {
            $data = json_decode($response->data, true);
            throw new OperationFailedException($data['error']);
        }
    }
}
