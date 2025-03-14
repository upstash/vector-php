<?php

namespace Upstash\Vector\Transporter;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Upstash\Vector\Contracts\TransporterInterface;
use Upstash\Vector\Contracts\TransporterPluginInterface;

/**
 * @internal
 */
final readonly class HttpTransporter implements TransporterInterface
{
    private Uri $uri;

    /**
     * @param  TransporterPluginInterface[]  $plugins
     */
    public function __construct(
        private ClientInterface $client,
        BaseUri $baseUri,
        private Headers $headers = new Headers,
        private array $plugins = [],
    ) {
        $this->uri = new Uri($baseUri);
    }

    public function sendRequest(TransporterRequest $request): TransporterResponse
    {
        $httpRequest = $this->transformRequest($request);

        $response = $this->client->sendRequest($httpRequest);

        return $this->transformResponse($response);
    }

    private function transformRequest(TransporterRequest $request): RequestInterface
    {
        // Build URL
        $url = $this->uri
            ->withPath($request->path)
            ->withSearchParams($request->searchParams)
            ->toString();

        $factory = Psr17FactoryDiscovery::findRequestFactory();

        // run expandRequest plugins
        foreach ($this->plugins as $plugin) {
            $request = $plugin->expandRequest($request);
        }

        // Create PSR-17 Request
        $psr17Request = $factory->createRequest(
            $request->method->value,
            $url,
        );

        // Add Base Headers
        foreach ($this->headers->toArray() as $header => $value) {
            $psr17Request = $psr17Request->withHeader($header, $value);
        }

        // Add Request Headers
        foreach ($request->headers->toArray() as $header => $value) {
            $psr17Request = $psr17Request->withHeader($header, $value);
        }

        // Add Content type
        $psr17Request = $psr17Request->withHeader('Content-Type', $request->contentType->value);

        // Add Request Body
        if ($request->hasBody()) {
            /** @phpstan-ignore method.notFound */
            $body = $factory->createStream(json_encode($request->data, JSON_THROW_ON_ERROR));
            $psr17Request = $psr17Request->withBody($body);
        }

        return $psr17Request;
    }

    private function transformResponse(ResponseInterface $response): TransporterResponse
    {
        $headers = new Headers;

        foreach ($response->getHeaders() as $header => $values) {
            $headers = $headers->withHeader($header, $values[0]);
        }

        return new TransporterResponse(
            statusCode: $response->getStatusCode(),
            contentType: $response->getHeaderLine('Content-Type'),
            headers: $headers,
            data: $response->getBody()->getContents(),
        );
    }
}
