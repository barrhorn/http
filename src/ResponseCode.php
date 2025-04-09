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

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
final class ResponseCode
{
    /**
     * @var int
     */
    public const int CONTINUE = 100;

    /**
     * @var int
     */
    public const int SWITCHING_PROTOCOLS = 101;

    /**
     * @var int
     */
    public const int PROCESSING = 102;

    /**
     * @var int
     */
    public const int EARLY_HINTS = 103;

    /**
     * @var int
     */
    public const int OK = 200;

    /**
     * @var int
     */
    public const int CREATED = 201;

    /**
     * @var int
     */
    public const int ACCEPTED = 202;

    /**
     * @var int
     */
    public const int NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * @var int
     */
    public const int NO_CONTENT = 204;

    /**
     * @var int
     */
    public const int RESET_CONTENT = 205;

    /**
     * @var int
     */
    public const int PARTIAL_CONTENT = 206;

    /**
     * @var int
     */
    public const int MULTI_STATUS = 207;

    /**
     * @var int
     */
    public const int ALREADY_REPORTED = 208;

    /**
     * @var int
     */
    public const int IM_USED = 226;

    /**
     * @var int
     */
    public const int MULTIPLE_CHOICES = 300;

    /**
     * @var int
     */
    public const int MOVED_PERMANENTLY = 301;

    /**
     * @var int
     */
    public const int FOUND = 302;

    /**
     * @var int
     */
    public const int SEE_OTHER = 303;

    /**
     * @var int
     */
    public const int NOT_MODIFIED = 304;

    /**
     * @var int
     */
    public const int USE_PROXY = 305;

    /**
     * In HTTP/2, this code is reserved for future use.
     * But, in HTTP/1.1, this code is used.
     * 
     * @var int
     */
    public const int RESERVED = 306;

    /**
     * @var int
     */
    public const int TEMPORARY_REDIRECT = 307;

    /**
     * @var int
     */
    public const int PERMANENT_REDIRECT = 308;

    /**
     * @var int
     */
    public const int BAD_REQUEST = 400;

    /**
     * @var int
     */
    public const int UNAUTHORIZED = 401;

    /**
     * @var int
     */
    public const int PAYMENT_REQUIRED = 402;

    /**
     * @var int
     */
    public const int FORBIDDEN = 403;

    /**
     * @var int
     */
    public const int NOT_FOUND = 404;

    /**
     * @var int
     */
    public const int METHOD_NOT_ALLOWED = 405;

    /**
     * @var int
     */
    public const int NOT_ACCEPTABLE = 406;

    /**
     * @var int
     */
    public const int PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * @var int
     */
    public const int REQUEST_TIMEOUT = 408;

    /**
     * @var int
     */
    public const int CONFLICT = 409;

    /**
     * @var int
     */
    public const int GONE = 410;

    /**
     * @var int
     */
    public const int LENGTH_REQUIRED = 411;

    /**
     * @var int
     */
    public const int PRECONDITION_FAILED = 412;

    /**
     * @var int
     */
    public const int CONTENT_TOO_LARGE = 413;

    /**
     * @var int
     */
    public const int URI_TOO_LONG = 414;

    /**
     * @var int
     */
    public const int UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * @var int
     */
    public const int RANGE_NOT_SATISFIABLE = 416;

    /**
     * @var int
     */
    public const int EXPECTATION_FAILED = 417;

    /**
     * @var int
     */
    public const int IM_A_TEAPOT = 418;

    /**
     * @var int
     */
    public const int MISDIRECTED_REQUEST = 421;

    /**
     * @var int
     */
    public const int UNPROCESSABLE_CONTENT = 422;

    /**
     * @var int
     */
    public const int LOCKED = 423;

    /**
     * @var int
     */
    public const int FAILED_DEPENDENCY = 424;

    /**
     * @var int
     */
    public const int TOO_EARLY = 425;

    /**
     * @var int
     */
    public const int UPGRADE_REQUIRED = 426;

    /**
     * @var int
     */
    public const int PRECONDITION_REQUIRED = 428;

    /**
     * @var int
     */
    public const int TOO_MANY_REQUESTS = 429;

    /**
     * @var int
     */
    public const int REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /**
     * @var int
     */
    public const int UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    /**
     * @var int
     */
    public const int INTERNAL_SERVER_ERROR = 500;

    /**
     * @var int
     */
    public const int NOT_IMPLEMENTED = 501;

    /**
     * @var int
     */
    public const int BAD_GATEWAY = 502;

    /**
     * @var int
     */
    public const int SERVICE_UNAVAILABLE = 503;

    /**
     * @var int
     */
    public const int GATEWAY_TIMEOUT = 504;

    /**
     * @var int
     */
    public const int HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * @var int
     */
    public const int VARIANT_ALSO_NEGOTIATES = 506;

    /**
     * @var int
     */
    public const int INSUFFICIENT_STORAGE = 507;

    /**
     * @var int
     */
    public const int LOOP_DETECTED = 508;

    /**
     * @var int
     */
    public const int NOT_EXTENDED = 510;

    /**
     * @var int
     */
    public const int NETWORK_AUTHENTICATION_REQUIRED = 511;
}
