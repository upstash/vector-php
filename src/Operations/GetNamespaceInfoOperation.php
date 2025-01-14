<?php

namespace Upstash\Vector\Operations;

use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\NamespaceInfo;

/**
 * @internal
 */
final readonly class GetNamespaceInfoOperation
{
    public function __construct(
        private string $namespace,
        private TransporterInterface $transporter,
    ) {}

    public function getNamespaceInfo(): NamespaceInfo
    {
        $operation = new GetIndexInfoOperation($this->transporter);

        $response = $operation->getInfo();

        return $response->namespace($this->namespace);
    }
}
