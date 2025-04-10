<?php

/**
 * This file is part of Barrhorn package.
 *
 * (c) Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 *
 * For complete information regarding copyright and licensing for
 * this source code, please refer to the LICENSE.md file that was included
 * in this repository.
 */

declare(strict_types=1);

namespace Barrhorn\Http;

use InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

use function array_merge;
use function explode;
use function is_array;
use function join;
use function strtolower;
use function ucfirst;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class AbstractMessage implements
    MessageInterface,
    MessageMutatorAwareInterface
{
    /**
     * @var string
     */
    private string $protocolVersion;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array
     */
    private array $headerNames;

    /**
     * @var array
     */
    private array $headerNamesMap = [
        'accept-ch' => 'Accept-CH',
        'content-dpr' => 'Content-DPR',
        'critical-ch' => 'Critical-CH',
        'dictionary-id' => 'Dictionary-ID',
        'dnt' => 'DNT',
        'dpr' => 'DPR',
        'ect' => 'ECT',
        'etag' => 'ETag',
        'expect-ct' => 'Expect-CT',
        'nel' => 'NEL',
        'rtt' => 'RTT',
        'sec-ch-prefers-color-scheme' => 'Sec-CH-Prefers-Color-Scheme',
        'sec-ch-prefers-reduced-motion' => 'Sec-CH-Prefers-Reduced-Motion',
        'sec-ch-prefers-reduced-transparency' => 'Sec-CH-Prefers-Reduced-Transparency',
        'sec-ch-ua' => 'Sec-CH-UA',
        'sec-ch-ua-arch' => 'Sec-CH-UA-Arch',
        'sec-ch-ua-bitness' => 'Sec-CH-UA-Bitness',
        'sec-ch-ua-form-factors' => 'Sec-CH-UA-Form-Factors',
        'sec-ch-ua-full-version' => 'Sec-CH-UA-Full-Version',
        'sec-ch-ua-full-version-list' => 'Sec-CH-UA-Full-Version-List',
        'sec-ch-ua-mobile' => 'Sec-CH-UA-Mobile',
        'sec-ch-ua-model' => 'Sec-CH-UA-Model',
        'sec-ch-ua-platform' => 'Sec-CH-UA-Platform',
        'sec-ch-ua-platform-version' => 'Sec-CH-UA-Platform-Version',
        'sec-ch-ua-wow64' => 'Sec-CH-UA-WoW64',
        'sec-gpc' => 'Sec-GPC',
        'sec-websocket-accept' => 'Sec-WebSocket-Accept',
        'sec-websocket-extensions' => 'Sec-WebSocket-Extensions',
        'sec-websocket-key' => 'Sec-WebSocket-Key',
        'sec-websocket-protocol' => 'Sec-WebSocket-Key',
        'sec-websocket-version' => 'Sec-WebSocket-Version',
        'sourcemap' => 'SourceMap',
        'te' => 'TE',
        'tk' => 'Tk',
        'www-authenticate' => 'WWW-Authenticate',
        'x-dns-prefetch-control' => 'X-DNS-Prefetch-Control',
        'x-xss-protection' => 'X-XSS-Protection'
    ];

    /**
     * @var \Barrhorn\Http\StreamInterface
     */
    private StreamInterface $body;

    /**
     * {@inheritDoc}
     */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritDoc}
     */
    public function setProtocolVersion(string $version): void
    {
        $this->protocolVersion = $version;
    }

    /**
     * {@inheritDoc}
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        $cloned = clone $this;
        $cloned->protocolVersion = $version;
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function hasHeader(string $name): bool
    {
        return isset($this->headerNames[strtolower($name)]);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader(string $name): array
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $key = $this->headerNames[strtolower($name)];
        $value = $this->headers[$key];
        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderLine(string $name): string
    {
        return join(',', $this->getHeader());
    }

    /**
     * {@inheritDoc}
     */
    public function setHeader(string $name, array|string $value): void
    {
        $lowerHeaderName = strtolower($name);
        $normalHeaderName = $this->normalizeHeaderName($lowerHeaderName);

        // ensure 'Host' header is at first entry.
        if ($normalHeaderName === 'Host' && !$this->hasHeader('host')) {
            $this->headerNames['host'] = 'Host';
            $this->headers = array_merge(
                ['Host' => is_array($value) ? $value : [$value]],
                $this->headers
            );

            return;
        }

        if (!$this->hasHeader($lowerHeaderName)) {
            $this->headerNames[$lowerHeaderName] = $normalHeaderName;
            $this->headers[$normalHeaderName] = is_array($value)
                ? $value
                : [$value];
            return;
        }

        $this->headers[$normalHeaderName] = is_array($value)
            ? $value
            : [$value];

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function removeHeader(string $name): void
    {
        if (!$this->hasHeader($name)) {
            return;
        }

        $lowerHeaderName = strtolower($name);
        $normalHeaderName = $this->normalizeHeaderName($lowerHeaderName);

        unset($this->headerNames[$lowerHeaderName]);
        unset($this->headers[$normalHeaderName]);
    }

    /**
     * {@inheritDoc}
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        $cloned = clone $this;
        $cloned->setHeader($name, $value);
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        $cloned = clone $this;
        $cloned->setHeader($name, $this->mergeHeaderValues(
            $this->getHeader($name),
            is_array($value) ? $value : [$value]
        ));

        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function withoutHeader(string $name): MessageInterface
    {
        $cloned = clone $this;
        $cloned->removeHeader($name);
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    /**
     * {@inheritDoc}
     */
    public function setBody(StreamInterface|resource $body): void
    {
        $this->body = is_resource($body)
            ? Stream::createFromResource($body)
            : $body;
    }

    /**
     * {@inheritDoc}
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        if (!($body instanceof MessageInterface)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Stream body must be instance of '%s'.",
                    StreamInterface::class
                )
            );
        }

        $cloned = clone $this;
        $cloned->body = $body;
        return $cloned;
    }

    /**
     * @param string $name
     * @return string
     */
    private function normalizeHeaderName(string $name): string
    {
        if (isset($this->headerNamesMap[$name])) {
            return $this->headerNamesMap[$name];
        }

        $splitted = explode('-', $name);

        foreach ($splitted as $key => $elem) {
            $splitted[$key] = ucfirst($elem);
        }

        return join('-', $splitted);
    }

    /**
     * @param array $source
     * @param array $added
     */
    private function mergeHeaderValues(array $source, array $added): array
    {
        $result = $source;

        foreach ($added as $elem) {
            $result[] = $elem;
        }

        return $result;
    }
}
