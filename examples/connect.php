<?php

require_once __DIR__.'/../vendor/autoload.php';

use Upstash\Vector\DataUpsert;
use Upstash\Vector\Index;

$index = new Index(
    url: 'https://valid-bobcat-26476-eu1-vector.upstash.io',
    token: 'ABYFMHZhbGlkLWJvYmNhdC0yNjQ3Ni1ldTFhZG1pbk56UmhNbVl4WW1VdFpUZ3pZaTAwWVdZeUxXRmxObVF0TWpJeE9XUXdaVFUwWlRNMw==',
);

$index->upsertData(new DataUpsert(
    id: '123',
    data: 'money',
));
