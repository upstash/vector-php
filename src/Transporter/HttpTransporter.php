<?php

namespace Upstash\Vector\Transporter;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Upstash\Vector\Contracts\TransporterInterface;

/**
 * @internal
 */
final readonly class HttpTransporter implements TransporterInterface
{
    private Uri $uri;

    public function __construct(
        private ClientInterface $client,
        BaseUri $baseUri,
        private Headers $headers = new Headers,
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
            ->toString();

        $factory = Psr17FactoryDiscovery::findRequestFactory();

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

        // Add Telemetry Headers
        $psr17Request = $this->addTelemetryHeaders($psr17Request);

        // Add Content type
        $psr17Request = $psr17Request->withHeader('Content-Type', $request->contentType->value);

        // Add Request Body
        if ($request->method->isMutation()) {
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

    private function addTelemetryHeaders(RequestInterface|MessageInterface $psr17Request): RequestInterface|MessageInterface
    {
        // TODO: Add PHP and Package Version
        return $psr17Request
            ->withHeader('Upstash-Telemetry-Runtime', 'php');
    }
}
