<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Data;

use Rkt\MageData\Data;

class MageUrlData extends Data
{
    public function __construct(
        public ?string $path = null,
        public ?array $params = null,
    ) {
    }
}
