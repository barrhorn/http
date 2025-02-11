<?php

declare(strict_types=1);

namespace Barrhorn\Http;

use Psr\Http\Message\MessageInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class AbstractMessage implements MessageInterface
{
    /**
     * @var array
     */
    private array $headers;

    /**
     * @var string
     */
    private string $protocolVersion;

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
        $cloned = new $this;
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
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader(string $name): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderLine(string $name): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function withoutHeader(string $name): MessageInterface
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody(): StreamInterface
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        return null;
    }
}
