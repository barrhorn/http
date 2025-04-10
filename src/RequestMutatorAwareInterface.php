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

use Psr\Http\Message\UriInterface;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface RequestMutatorAwareInterface
{
    /**
     * @param string $method
     * @return void
     */
    public function setMethod(string $method): void;

    /**
     * @param \Psr\Http\Message\UriInterface $uri
     * @return void
     */
    public function setUri(UriInterface $uri): void;
}
