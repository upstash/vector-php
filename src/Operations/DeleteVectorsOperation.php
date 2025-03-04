<?php

namespace Upstash\Vector\Operations;

use InvalidArgumentException;
use Upstash\Vector\Contracts\Arrayable;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Contracts\VectorIdentifierInterface;
use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Operations\Concerns\AssertsApiResponseErrors;
use Upstash\Vector\Transporter\ContentType;
use Upstash\Vector\Transporter\Method;
use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;
use Upstash\Vector\VectorDeleteByMetadataFilter;
use Upstash\Vector\VectorDeleteByPrefix;
use Upstash\Vector\VectorDeleteResult;

/**
 * @internal
 */
final readonly class DeleteVectorsOperation
{
    use AssertsApiResponseErrors;

    public function __construct(private string $namespace, private TransporterInterface $transporter) {}

    /**
     * @param  string[]|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter  $ids
     *
     * @throws OperationFailedException
     */
    public function delete(array|string|VectorDeleteByPrefix|VectorDeleteByMetadataFilter $ids): VectorDeleteResult
    {
        if ($ids instanceof Arrayable) {
            return $this->sendDeleteRequest($ids->toArray());
        }

        if (is_string($ids)) {
            return $this->sendDeleteRequest([
                'ids' => [$ids],
            ]);
        }

        return $this->sendDeleteRequest([
            'ids' => $this->mapIds($ids),
        ]);
    }

    private function getPath(): string
    {
        $namespace = trim($this->namespace);
        if ($namespace === '') {
            return '/delete';
        }

        return "/delete/$namespace";
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function sendDeleteRequest(array $payload): VectorDeleteResult
    {
        try {
            $request = new TransporterRequest(
                contentType: ContentType::JSON,
                method: Method::DELETE,
                path: $this->getPath(),
                data: $payload,
            );
        } catch (\JsonException $e) {
            throw new OperationFailedException('Invalid JSON');
        }

        $response = $this->transporter->sendRequest($request);

        $this->assertResponse($response);

        return $this->transformResponse($response);
    }

    private function transformResponse(TransporterResponse $response): VectorDeleteResult
    {
        $data = json_decode($response->data, true)['result'] ?? [];

        return new VectorDeleteResult(
            deleted: $data['deleted'] ?? 0,
        );
    }

    /**
     * @param  array<string|VectorIdentifierInterface|mixed>  $ids
     * @return array<string>
     */
    private function mapIds(array $ids): array
    {
        $result = [];
        foreach ($ids as $id) {
            if ($id instanceof VectorIdentifierInterface) {
                $result[] = $id->getIdentifier();

                continue;
            }

            if (is_string($id)) {
                $result[] = $id;

                continue;
            }

            throw new InvalidArgumentException('Invalid ID, should be a string');
        }

        return $result;
    }
}
