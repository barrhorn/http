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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

use function is_string;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
abstract class AbstractRequest extends AbstractMessage implements
    RequestInterface,
    RequestMutatorAwareInterface
{
    /**
     * @var string
     */
    private string $requestTarget;

    /**
     * @var string
     */
    private string $method;

    /**
     * @var \Psr\Http\Message\UriInterface
     */
    private UriInterface $uri;

    /**
     * {@inheritDoc}
     */
    public function getRequestTarget(): string
    {
        if (null !== $this->requestTarget) {
            return $this->requestTarget;
        }

        if ('' === $target = $this->uri->getPath()) {
            $target = '/';
        }

        if ('' !== $this->uri->getQuery()) {
            $target .= '?' . $this->uri->getQuery();
        }

        return $target;
    }

    /**
     * {@inheritDoc}
     */
    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        $cloned = clone $this;
        $cloned->requestTarget = $requestTarget;
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * {@inheritDoc}
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * {@inheritDoc}
     */
    public function withMethod(string $method): UriInterface
    {
        $cloned = clone $this;
        $cloned->setMethod($method);
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    /**
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @return void
     */
    public function setUri(UriInterface|string $uri): void
    {
        $this->uri = is_string($uri)
            ? Uri::create($uri)
            : $uri;
    }

    /**
     * {@inheritDoc}
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {
        if ($uri === $this->uri) {
            return $this;
        }

        $cloned = clone $this;
        $cloned->uri = $uri;

        if (!$preserveHost || !$this->hasHeader('host')) {
            $cloned->updateHostHeaderFromUri();
        }

        return $cloned;
    }

    /**
     * @internal
     * @return void
     */
    protected function updateHostHeaderFromUri(): void
    {
        if ('' === $host = $this->uri->getHost()) {
            return;
        }

        if (null !== $port = $this->uri->getPort()) {
            $host .= ':' . $port;
        }

        $this->removeHeader('host');
        $this->setHeader('host', $host);
    }
}
