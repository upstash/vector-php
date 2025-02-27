<?php

namespace Upstash\Vector;

use Upstash\Vector\Contracts\Transformers\ToDeletablePayloadInterface;

final readonly class VectorDelete implements ToDeletablePayloadInterface
{
    /**
     * @var string[]
     */
    public array $ids;

    /**
     * @param  string[]|string  $ids
     */
    public function __construct(array|string $ids = [])
    {
        if (is_string($ids)) {
            $this->ids = [$ids];
        } else {
            $this->ids = array_values(array_unique($ids));
        }
    }

    /**
     * @param  string[]|string  $ids
     */
    public static function fromIds(array|string $ids): VectorDelete
    {
        return new VectorDelete($ids);
    }

    public static function fromPrefix(string $prefix): VectorPrefixDelete
    {
        return new VectorPrefixDelete($prefix);
    }

    public static function fromMetadataFilter(string $filter): VectorFilterDelete
    {
        return new VectorFilterDelete($filter);
    }

    /**
     * @return array{
     *     ids: string[]
     * }
     */
    public function toDeletablePayload(): array
    {
        return [
            'ids' => $this->ids,
        ];
    }
}
