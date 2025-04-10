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

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface MessageMutatorAwareInterface
{
    /**
     * @param string $name
     * @param array|string $value
     * @return void
     */
    public function setHeader(string $name, array|string $value): void;

    /**
     * @param string $name
     * @return void
     */
    public function removeHeader(string $name): void;

    /**
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers): void;

    /**
     * @param \Psr\Http\Message\StreamInterface|resource $body
     * @return void
     */
    public function setBody(StreamInterface|resource $body): void;
}
