<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

/**
 * Enum representing the possible values for the `hx-swap` attribute.
 * Controls how the returned HTML will be swapped into the target element.
 */
enum HtmxSwapOption: string
{
    /**
     * Replaces the entire content of the target element.
     */
    case INNER_HTML = 'innerHTML';

    /**
     * Replaces the target element itself.
     */
    case OUTER_HTML = 'outerHTML';

    /**
     * Appends the response content inside the target element.
     */
    case BEFORE_END = 'beforeend';

    /**
     * Prepends the response content inside the target element.
     */
    case AFTER_BEGIN = 'afterbegin';

    /**
     * Inserts the response content just before the target element.
     */
    case BEFORE_BEGIN = 'beforebegin';

    /**
     * Inserts the response content just after the target element.
     */
    case AFTER_END = 'afterend';

    /**
     * Does not swap the content at all.
     */
    case NONE = 'none';

    /**
     * A custom swap strategy defined in JavaScript.
     */
    case CUSTOM = 'custom';
}
