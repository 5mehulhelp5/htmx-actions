<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Data;

use Rkt\MageData\Data;

class HxAttributesData extends Data
{
    public function __construct(
        public null|string|MageUrlData $get = null,
        public null|string|MageUrlData $post = null,
        public ?string $target = null,
        public ?string $swap = null,
        public ?string $indicator = null,
        public ?array $on = [],
    ) {
    }
}
