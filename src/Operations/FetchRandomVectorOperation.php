<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Operations\Concerns\MapsVectorMatches;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorMatch;

/**
 * @internal
 */
final readonly class FetchRandomVectorOperation
{
    use AssertsApiResponseErrors;
    use MapsVectorMatches;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function fetch(): ?VectorMatch
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: $this->getPath(),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace !== '') {
            return "/random/$namespace";
        }

        return '/random';
    }

    private function transformResponse(TransporterResponse $response): ?VectorMatch
    {
        $data = json_decode($response->data, true);

        $result = $data['result'] ?? null;
        if ($result === null) {
            return null;
        }

        return $this->mapVectorMatch($result);
    }
}
