<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorUpsert;

/**
 * @internal
 */
final readonly class UpsertVectorOperation
{
    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function upsert(VectorUpsert $upsert): void
    {
        $request = $this->createRequest($upsert->toArray());

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    /**
     * @param  array<VectorUpsert>  $upsert
     */
    public function upsertMany(array $upsert): void
    {
        $data = array_map(fn (VectorUpsert $upsert) => $upsert->toArray(), $upsert);
        $request = $this->createRequest($data);

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    private function createRequest(array $data): TransporterRequest
    {
        $namespace = trim($this->namespace);
        $path = '/upsert';
        if ($namespace !== '') {
            $path = "/upsert/$namespace";
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
        // TODO: Assert errors and throw exceptions
    }
}
