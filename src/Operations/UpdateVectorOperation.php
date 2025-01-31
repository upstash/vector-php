<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\VectorUpdate;

final readonly class UpdateVectorOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function update(VectorUpdate $update): void
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::POST,
            path: $this->getPath(),
            data: $update->toArray(),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace !== '') {
            return "/update/$namespace";
        }

        return '/update';
    }
}
