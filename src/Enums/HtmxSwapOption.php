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
    case innerHTML = 'innerHTML';

    /**
     * Replaces the target element itself.
     */
    case outerHTML = 'outerHTML';

    /**
     * Appends the response content inside the target element.
     */
    case beforeEnd = 'beforeend';

    /**
     * Prepends the response content inside the target element.
     */
    case afterBegin = 'afterbegin';

    /**
     * Inserts the response content just before the target element.
     */
    case beforeBegin = 'beforebegin';

    /**
     * Inserts the response content just after the target element.
     */
    case afterEnd = 'afterend';

    /**
     * Does not swap the content at all.
     */
    case none = 'none';

    /**
     * A custom swap strategy defined in JavaScript.
     */
    case custom = 'custom';
}
