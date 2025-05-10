<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Enums;

/**
 * Enum listing all standard HTMX request headers.
 * These headers are sent automatically by HTMX in each request.
 */
enum HtmxRequestHeader: string
{
    /**
     * Indicates the request was made via HTMX (always set to 'true')
     */
    case REQUEST = 'HX-Request';

    /**
     * The URL of the page that initiated the HTMX request
     */
    case CURRENT_URL = 'HX-Current-URL';

    /**
     * The ID of the target element where the response will be swapped
     */
    case TARGET = 'HX-Target';

    /**
     * The ID of the element that triggered the HTMX request
     */
    case TRIGGER = 'HX-Trigger';

    /**
     * The name of the triggering input element (e.g., from a form field)
     */
    case TRIGGER_NAME = 'HX-Trigger-Name';

    /**
     * The value entered by the user via `hx-prompt`, if used
     */
    case PROMPT = 'HX-Prompt';

    /**
     * A JSON-encoded object describing the event that triggered the request
     */
    case TRIGGERING_EVENT = 'HX-Triggering-Event';
}
