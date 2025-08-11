<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Data;

use MageHx\HtmxActions\Enums\HtmxSwapOption;
use Rkt\MageData\Data;

class HxAttributesData extends Data
{
    public function __construct(
        public null|string|MageUrlData $get = null,
        public null|string|MageUrlData $post = null,
        public ?string $target = null,
        public ?HtmxSwapOption $swap = null,
        public ?string $indicator = null,
        public ?string $trigger =  null,
        public ?bool $swapOOB = null,
        public ?array $include = null,
        public ?array $vals = null,
        public ?array $on = null,
        public ?bool $validate = null,
    ) {
    }
}
