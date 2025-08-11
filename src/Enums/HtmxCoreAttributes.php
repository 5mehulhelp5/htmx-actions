<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

use MageHx\HtmxActions\Enums\Trait\FromName;

enum HtmxCoreAttributes: string
{
    use FromName;

    case get = 'hx-get';
    case post = 'hx-post';
    case swap = 'hx-swap';
    case target = 'hx-target';
    case trigger = 'hx-trigger';
    case on = 'hx-on';
    case swapOOB = 'hx-swap-oob';
    case vals = 'hx-vals';
}
