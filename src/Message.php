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

use function is_array;
use function join;
use function strtolower;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class Message implements MessageInterface
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
    public function withHeader(string $name, $value): MessageInterface
    {
        $cloned = clone $this;

        $lowerHeaderName = strtolower($name);
        $normalHeaderName = $this->normalizeHeaderName($lowerHeaderName);

        $cloned->headerNames[$lowerHeaderName] = $normalHeaderName;
        $cloned->headers[$normalHeaderName] = is_array($value) ? $value : [$value];
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        $cloned = clone $this;

        $lowerHeaderName = strtolower($name);
        $normalHeaderName = $this->normalizeHeaderName($lowerHeaderName);

        if (!$this->hasHeader($lowerHeaderName)) {
            $cloned->headerNames[$lowerHeaderName] = $normalHeaderName;
            $cloned->headers[$normalHeaderName] = is_array($value) ? $value : [$value];
            return $cloned;
        }

        $cloned->headers[$normalHeaderName] = $this->mergeHeaderValues(
            $cloned->headers[$normalHeaderName],
            is_array($value) ? $value : [$value]
        );

        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function withoutHeader(string $name): MessageInterface
    {
        $cloned = clone $this;

        $lowerHeaderName = strtolower($name);
        $normalHeaderName = $this->normalizeHeaderName($lowerHeaderName);

        unset($cloned->headerNames[$lowerHeaderName]);
        unset($cloned->headers[$normalHeaderName]);

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
}
