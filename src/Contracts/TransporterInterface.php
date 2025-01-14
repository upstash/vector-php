<?php

namespace Upstash\Vector\Contracts;

use Upstash\Vector\Transporter\TransporterRequest;
use Upstash\Vector\Transporter\TransporterResponse;

interface TransporterInterface
{
    public function sendRequest(TransporterRequest $request): TransporterResponse;
}
