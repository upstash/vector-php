<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\DataUpsert;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;

/**
 * @internal
 */
final readonly class UpsertDataOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function upsert(DataUpsert $upsert): void
    {
        $request = $this->createRequest($upsert->toArray());
        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    /**
     * @param  array<DataUpsert>  $upsert
     */
    public function upsertMany(array $upsert): void
    {
        $data = array_map(fn (DataUpsert $upsert) => $upsert->toArray(), array_values($upsert));
        $request = $this->createRequest($data);

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    /**
     * @param  array<mixed>  $data
     */
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
}
