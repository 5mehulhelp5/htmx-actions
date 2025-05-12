<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Service;

use MageHx\HtmxActions\Enums\HtmxRequestHeader;
use MageHx\HtmxActions\Enums\HtmxResponseHeader;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;

class HtmxHeaderReader
{
    public function __construct(private readonly RequestInterface $request)
    {
    }

    public function isHtmxRequest(): bool
    {
        return $this->getRequestHeader(HtmxRequestHeader::REQUEST) === 'true';
    }

    public function getRequestHeader(HtmxRequestHeader $header): ?string
    {
        return $this->request->getHeader($header->value);
    }

    public function getOriginUrl(): string
    {
        return $this->getRequestHeader(HtmxRequestHeader::CURRENT_URL) ?? '';
    }

    public function getTriggerName(): string
    {
        return $this->getRequestHeader(HtmxRequestHeader::TRIGGER_NAME) ?? '';
    }

    public function isTriggerSameAs(string $name): bool
    {
        return $this->getTriggerName() === $name;
    }

    public function getAllRequestHeaders(): array
    {
        $headers = [];

        foreach (HtmxRequestHeader::cases() as $header) {
            $value = $this->getRequestHeader($header);

            if ($value !== null) {
                $headers[$header->value] = $value;
            }
        }

        return $headers;
    }

    public function setResponseHeader(
        ResultInterface $response,
        HtmxResponseHeader $header,
        string $value,
        bool $replace = true
    ): ResultInterface {
        return $response->setHeader($header->value, $value, $replace);
    }

    public function setMultipleResponseHeaders(ResultInterface $response, array $headers): ResultInterface
    {
        foreach ($headers as $header => $value) {
            if ($header instanceof HtmxResponseHeader) {
                $response->setHeader($header->value, $value);
            }
        }

        return $response;
    }

    public function setResponsePushUrl(ResultInterface $response, string $value, bool $replace = true): ResultInterface
    {
        return $this->setResponseHeader($response, HtmxResponseHeader::PUSH_URL, $value, $replace);
    }
}
