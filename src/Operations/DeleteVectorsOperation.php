<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorDeleteResult;

/**
 * @internal
 */
final readonly class DeleteVectorsOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    /**
     * @param  array<string>  $ids
     */
    public function delete(array $ids): VectorDeleteResult
    {
        $path = $this->getPath();

        try {
            $request = new TransporterRequest(
                contentType: ContentType::JSON,
                method: Method::DELETE,
                path: $path,
                data: $ids,
            );
        } catch (\JsonException $e) {
            throw new OperationFailedException('Invalid JSON');
        }

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace === '') {
            return '/delete';
        }

        return "/delete/$namespace";
    }

    private function transformResponse(TransporterResponse $response): VectorDeleteResult
    {
        $data = json_decode($response->data, true)['result'] ?? [];

        return new VectorDeleteResult(
            deleted: $data['deleted'] ?? 0,
        );
    }
}
