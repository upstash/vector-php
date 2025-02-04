# Vector Client SDK for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)
[![Tests](https://img.shields.io/github/actions/workflow/status/upstash/vector-php/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/upstash/vector-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)

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

## Usage

### Initialize the index
```php
use Upstash\Vector\Index;

// Initialize the index
$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

// or just to use the environment variables
$index = Index::fromEnv();
```

### Upserting Vectors


```php
use Upstash\Vector\Index;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->upsert(new VectorUpsert(
    id: 'upstash-rocks',
    vector: createRandomVector(dimensions: 1536),
    metadata: ['field' => 'value'],
));
```

### Upserting Data with Embedding Models

```php
use Upstash\Vector\Index;
use Upstash\Vector\DataUpsert;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->upsertData(new DataUpsert(
    id: 'upstash-vector',
    data: 'Upstash Vector is a serverless vector database.',
    metadata: ['field' => 'value'],
));
```

### Querying Vectors

```php
use Upstash\Vector\Index;
use Upstash\Vector\VectorQuery;

use function Upstash\Vector\createRandomVector;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->query(new VectorQuery(
    vector: createRandomVector(dimensions: 1536),
    topK: 5,
));
```

### Querying Data with Embedding Models

```php
use Upstash\Vector\Index;
use Upstash\Vector\DataQuery;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->queryData(new DataQuery(
    data: 'What is Upstash Vector?',
    topK: 5,
));
```

### Fetch specific vectors

```php
use Upstash\Vector\Index;
use Upstash\Vector\VectorFetch;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->fetch(new VectorFetch(ids: ['upstash-rocks']));
```

### Delete specific vectors

```php
use Upstash\Vector\Index;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

$index->delete(['upstash-rocks']);
```

## Namespaces
Upstash Vector allows you to partition a single index into multiple isolated namespaces. Each namespace functions as a self-contained subset of the index, in which read and write requests are only limited to one namespace. To learn more about it, [see Namespaces](https://upstash.com/docs/vector/features/namespaces).

### Example
```php
use Upstash\Vector\Index;
use Upstash\Vector\VectorUpsert;

use function Upstash\Vector\createRandomVector;

$index = new Index(
    url: 'UPSTASH_VECTOR_REST_URL',
    token: 'UPSTASH_VECTOR_REST_TOKEN',
);

// Upsert to namespace
$index->namespace('books')->upsert(new VectorUpsert(
    id: 'upstash-rocks',
    vector: createRandomVector(dimensions: 1536),
    metadata: ['field' => 'value'],
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
