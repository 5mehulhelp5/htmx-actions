<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Controller\Result;

use Magento\Framework\Controller\Result\Raw;

class HtmxRaw extends Raw
{
    public function getHeader(string $headerName): array
    {
        return array_filter($this->headers, fn ($header) => $header['name'] === $headerName);
    }

    public function hasHeader(string $headerName): bool
    {
        return !empty($this->getHeader($headerName));
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }
}
