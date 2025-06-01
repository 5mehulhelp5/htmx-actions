<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

enum HtmxCoreAttributes: string
{
    case get = 'hx-get';
    case post = 'hx-post';
    case swap = 'hx-swap';
    case target = 'hx-target';
    case trigger = 'hx-trigger';
    case on = 'hx-on';
    case swapOob = 'hx-swap-oob';
    case vals = 'hx-vals';
}
