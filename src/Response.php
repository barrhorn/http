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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use function sprintf;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class Response extends AbstractMessage implements ResponseInterface
{
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var string
     */
    private string $reasonPhrase;

    /**
     * @var array
     */
    private array $statusCodeMap = [
        ResponseCode::CONTINUE => 'Continue',
        ResponseCode::SWITCHING_PROTOCOLS => 'Switching Protocols',
        ResponseCode::PROCESSING => 'Processing',
        ResponseCode::EARLY_HINTS => 'Early Hints',
        ResponseCode::OK => 'OK',
        ResponseCode::CREATED => 'Created',
        ResponseCode::ACCEPTED => 'Accepted',
        ResponseCode::NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
        ResponseCode::NO_CONTENT => 'No Content',
        ResponseCode::RESET_CONTENT => 'Reset Content',
        ResponseCode::PARTIAL_CONTENT => 'Partial Content',
        ResponseCode::MULTI_STATUS => 'Multi-Status',
        ResponseCode::ALREADY_REPORTED => 'Already Reported',
        ResponseCode::IM_USED => 'IM Used',
        ResponseCode::MULTIPLE_CHOICES => 'Multiple Choices',
        ResponseCode::MOVED_PERMANENTLY => 'Moved Permanently',
        ResponseCode::FOUND => 'Found',
        ResponseCode::SEE_OTHER => 'See Other',
        ResponseCode::NOT_MODIFIED => 'Not Modified',
        ResponseCode::USE_PROXY => 'Use Proxy',
        ResponseCode::TEMPORARY_REDIRECT => 'Temporary Redirect',
        ResponseCode::PERMANENT_REDIRECT => 'Permanent Redirect',
        ResponseCode::BAD_REQUEST => 'Bad Request',
        ResponseCode::UNAUTHORIZED => 'Unauthorized',
        ResponseCode::PAYMENT_REQUIRED => 'Payment Required',
        ResponseCode::FORBIDDEN => 'Forbidden',
        ResponseCode::NOT_FOUND => 'Not Found',
        ResponseCode::METHOD_NOT_ALLOWED => 'Method Not Allowed',
        ResponseCode::NOT_ACCEPTABLE => 'Not Acceptable',
        ResponseCode::PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
        ResponseCode::REQUEST_TIMEOUT => 'Request Timeout',
        ResponseCode::CONFLICT => 'Conflict',
        ResponseCode::GONE => 'Gone',
        ResponseCode::LENGTH_REQUIRED => 'Length Required',
        ResponseCode::PRECONDITION_FAILED => 'Precondition Failed',
        ResponseCode::CONTENT_TOO_LARGE => 'Content Too Large',
        ResponseCode::URI_TOO_LONG => 'URI Too Long',
        ResponseCode::UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        ResponseCode::RANGE_NOT_SATISFIABLE => 'Range Not Satisfiable',
        ResponseCode::EXPECTATION_FAILED => 'Expectation Failed',
        ResponseCode::IM_A_TEAPOT => 'I\'m a teapot',
        ResponseCode::MISDIRECTED_REQUEST => 'Misdirected Request',
        ResponseCode::UNPROCESSABLE_CONTENT => 'Unprocessable Content',
        ResponseCode::LOCKED => 'Locked',
        ResponseCode::FAILED_DEPENDENCY => 'Failed Dependency',
        ResponseCode::TOO_EARLY => 'Too Early',
        ResponseCode::UPGRADE_REQUIRED => 'Upgrade Required',
        ResponseCode::PRECONDITION_REQUIRED => 'Precondition Required',
        ResponseCode::TOO_MANY_REQUESTS => 'Too Many Requests',
        ResponseCode::REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
        ResponseCode::UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable For Legal Reasons',
        ResponseCode::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        ResponseCode::NOT_IMPLEMENTED => 'Not Implemented',
        ResponseCode::BAD_GATEWAY => 'Bad Gateway',
        ResponseCode::SERVICE_UNAVAILABLE => 'Service Unavailable',
        ResponseCode::GATEWAY_TIMEOUT => 'Gateway Timeout',
        ResponseCode::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        ResponseCode::VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
        ResponseCode::INSUFFICIENT_STORAGE => 'Insufficient Storage',
        ResponseCode::LOOP_DETECTED => 'Loop Detected',
        ResponseCode::NOT_EXTENDED => 'Not Extended',
        ResponseCode::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required'
    ];

    /**
     * @param int $statusCode
     * @param array $headers
     * @param \Psr\Http\Message\StreamInterface|resource $body
     * @param string $reasonPhrase
     * @param string $version
     */
    public function __construct(
        int $statusCode = ResponseCode::OK,
        array $headers = [],
        StreamInterface|resource $body = null,
        string $reasonPhrase = '',
        string $version = '1.1'
    ) {
        $this->checkStatusCode($code);

        $this->statusCode = $statusCode;
        $this->reasonPhrase = '' === $reasonPhrase
            ? $this->statusCodeMap[$this->statusCode]
            : $reasonPhrase;

        $this->setHeaders($headers);
        $this->setBody($body);
        $this->setProtocolVersion($version);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * {@inheritDoc}
     */
    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        $this->checkStatusCode($code);

        $cloned = clone $this;
        $cloned->statusCode = $code;
        $cloned->reasonPhrase = '' === $reasonPhrase
            ? $this->statusCodeMap[$this->statusCode]
            : $reasonPhrase;
        return $cloned;
    }

    /**
     * {@inheritDoc}
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @internal
     *
     * @param int $statusCode
     * @return void
     * @throws \InvalidArgumentException If HTTP status code is invalid
     */
    private function checkStatusCode(int $statusCode): void
    {
        if (!isset($this->statusCodeMap[$statusCode])) {
            throw new InvalidArgumentException(
                sprintf('Status code (%d) not found.', $statusCode)
            );
        }
    }
}
