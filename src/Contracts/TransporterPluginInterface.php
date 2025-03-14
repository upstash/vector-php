<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\Transporter\TransporterRequest;

interface TransporterPluginInterface
{
    public function expandRequest(TransporterRequest $request): TransporterRequest;
}
