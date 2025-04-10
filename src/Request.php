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

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class Request extends AbstractRequest
{
    /**
     * @param string $method
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $headers
     * @param \Psr\Http\Message\StreamInterface|resource $body
     * @param string $version
     */
    public function __construct(
        string $method,
        UriInterface|string $uri,
        array $headers = [],
        StreamInterface|resource $body = null,
        string $version = '1.1'
    ) {
        $this->setMethod($method);
        $this->setUri($uri);
        $this->setHeaders($headers);
        $this->setBody($body);
        $this->setProtocolVersion($version);
    }
}
