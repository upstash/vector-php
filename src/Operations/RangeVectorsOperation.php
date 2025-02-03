<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Iterators\VectorRangeIterator;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Operations\Concerns\MapsVectorMatches;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorRange;
use Upstash\Vector\VectorRangeResult;

/**
 * @internal
 */
final readonly class RangeVectorsOperation
{
    use AssertsApiResponseErrors;
    use MapsVectorMatches;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    public function range(VectorRange $range): VectorRangeResult
    {
        $request = new TransporterRequest(
            contentType: ContentType::JSON,
            method: Method::GET,
            path: $this->getPath(),
            data: $range->toArray(),
        );

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response, $range);
    }

    public function rangeIterator(VectorRange $range): VectorRangeIterator
    {
        return new VectorRangeIterator($this, $range);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace !== '') {
            return "/range/$namespace";
        }

        return '/range';
    }

    private function transformResponse(TransporterResponse $response, VectorRange $range): VectorRangeResult
    {
        $data = json_decode($response->data, true);
        $result = $data['result'] ?? [];

        $nextCursor = $result['nextCursor'] ?? '0';
        $vectors = $result['vectors'] ?? [];

        $vectors = array_map(fn (array $vector) => $this->mapVectorMatch($vector), $vectors);

        return new VectorRangeResult(
            results: $vectors,
            nextCursor: $nextCursor,
            originalRange: $range,
            operation: $this,
        );
    }
}
