# Vector Client SDK for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)
[![Tests](https://img.shields.io/github/actions/workflow/status/upstash/vector-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/upstash/vector-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)

> **This project is still in development.**

Upstash Vector is an HTTP serverless Vector Database.

You can store, query, and retrieve vectors from your application, use it to power your search, and more.

You can read more about Upstash Vector [here](https://docs.upstash.com/vector).

## Quick Start

### Installation

You can install the package via composer:

```bash
composer require upstash/vector
```

### Create Index

Create a new index on [Upstash](https://console.upstash.com/vector)

### Basic Usage

```php
use Upstash\Vector\Index;

// Initialize the index
$index = new Index(
    url: '<UPSTASH_VECTOR_REST_URL>',
    token: '<UPSTASH_VECTOR_REST_TOKEN>',
);

// or just to use the environment variables
$index = Index::fromEnv();

// Upsert to dense index
use Upstash\Vector\VectorUpsert;

$index->upsert(new VectorUpsert(
    id: 'upstash-rocks',
    vector: [
        0.13, 0.87, ... // dense embedding
    ],
    metadata: [
        'title' => 'Lord of The Rings',
        'genre' => 'fantasy',
        'category' => 'classic',
    ],
));

// Upsert data as plain text.
use Upstash\Vector\DataUpsert;

$index->upsertData(new DataUpsert(
    id: 'tokyo',
    data: 'Tokyo is the capital of Japan.',
));

// Query Vector Data
use Upstash\Vector\VectorQuery;

$result = $index->query(new VectorQuery(
    vector: [0.13, 0.87, ...], // dense embedding
    includeVectors: true,
    includeMetadata: true,
    topK: 1,
));


// Query with your data
use Upstash\Vector\DataQuery;

$result = $index->queryData(new DataQuery(
    data: 'What is the capital of Japan?',
    topK: 1,
));
```

## Namespaces
Upstash Vector allows you to partition a single index into multiple isolated namespaces. Each namespace functions as a self-contained subset of the index, in which read and write requests are only limited to one namespace. To learn more about it, see Namespaces

### Example
```php
use Upstash\Vector\Index;

$index = Index::fromEnv();

$namespace = $index->namespace('books');

// Upsert to namespace
$namespace->upsert(new VectorUpsert(
    id: 'lord-of-the-rings',
    vector: [0.13, 0.87, ...],
    metadata: [
        'title' => 'Lord of The Rings',
        'genre' => 'fantasy',
        'category' => 'classic',
    ],
));
```

## Troubleshooting

We have a [Discord](upstash.com/discord) for common problems. If you can't find a solution, please [open an issue](https://github.com/upstash/vector-js/issues/new).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
