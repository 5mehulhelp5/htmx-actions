<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

use MageHx\HtmxActions\Enums\Trait\FromName;

enum HtmxAdditionalAttributes: string
{
    use FromName;

    case indicator = 'hx-indicator';
    case include = 'hx-include';
    case validate = 'hx-validate';
}
