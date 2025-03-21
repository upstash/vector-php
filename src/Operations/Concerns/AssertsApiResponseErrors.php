<?php

namespace Upstash\Vector\Operations\Concerns;

use Upstash\Vector\Exceptions\OperationFailedException;
use Upstash\Vector\Exceptions\WrongIndexDimensionsException;
use Upstash\Vector\Transporter\TransporterResponse;

trait AssertsApiResponseErrors
{
    private function assertResponse(TransporterResponse $response): void
    {
        if ($response->statusCode === 200) {
            return;
        }

        $data = json_decode($response->data, true);

        if ($response->statusCode === 422) {
            $error = $data['error'] ?? '';

            if (str_contains($error, 'Invalid vector dimension')) {
                throw new WrongIndexDimensionsException($error);
            }

            throw new OperationFailedException($data['error']);
        }

        if ($response->statusCode > 500 && $response->statusCode < 600) {
            throw new OperationFailedException($data['error']);
        }
    }
}
