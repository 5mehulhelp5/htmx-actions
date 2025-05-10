<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

/**
 * Enum representing HTMX response headers that control client-side behavior.
 * These are sent from the server back to the browser to modify HTMX behavior.
 */
enum HtmxResponseHeader: string
{
    /**
     * Redirect the browser to a new URL (client-side redirect with push)
     */
    case LOCATION = 'HX-Location';

    /**
     * Trigger a full browser redirect (not just HTMX swap)
     */
    case REDIRECT = 'HX-Redirect';

    /**
     * Refresh the current page (useful after server-side changes)
     */
    case REFRESH = 'HX-Refresh';

    /**
     * Change the target DOM element for the current swap
     */
    case RETARGET = 'HX-Retarget';

    /**
     * Reselect a DOM element after the swap (e.g., to re-focus or update it)
     */
    case RESELECT = 'HX-Reselect';

    /**
     * Replace the current URL in browser history (like pushState)
     */
    case REPLACE_URL = 'HX-Replace-Url';

    /**
     * Push or replace a URL into the browser's history stack
     */
    case PUSH_URL = 'HX-Push-Url';

    /**
     * Trigger a custom JavaScript event on the client
     */
    case TRIGGER = 'HX-Trigger';

    /**
     * Trigger an event after the DOM has settled (e.g., animations complete)
     */
    case TRIGGER_AFTER_SETTLE = 'HX-Trigger-After-Settle';

    /**
     * Trigger an event after the DOM has been swapped
     */
    case TRIGGER_AFTER_SWAP = 'HX-Trigger-After-Swap';
}
