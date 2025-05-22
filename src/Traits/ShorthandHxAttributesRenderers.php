<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Traits;

use MageHx\HtmxActions\Enums\HtmxAdditionalAttributes;
use MageHx\HtmxActions\Enums\HtmxCoreAttributes;
use MageHx\HtmxActions\Model\HxAttributeRender\HxAttributesRenderer;

/**
 * Provides shorthand methods to render common HTMX attributes via `$this->renderer->render()`.
 *
 * The consuming class must define a `renderer` property that implements
 * a `render(array $attributes): string` method.
 *
 * Example: <button <?= $block->post('/checkout')  ?>>Place Order</button>;
 *
 * @property HxAttributesRenderer $renderer
 */
trait ShorthandHxAttributesRenderers
{
    /**
     * Renders `hx-post="/url"`
     */
    public function post(string $url): string
    {
        return $this->renderer->render([HtmxCoreAttributes::post->name => $url]);
    }

    /**
     * Renders `hx-get="/url"`
     */
    public function get(string $url): string
    {
        return $this->renderer->render([HtmxCoreAttributes::get->name => $url]);
    }

    /**
     * Renders `hx-target="#selector"`
     */
    public function target(string $selector): string
    {
        return $this->renderer->render([HtmxCoreAttributes::target->name => $selector]);
    }

    /**
     * Renders `hx-swap="strategy"`
     */
    public function swap(string $strategy): string
    {
        return $this->renderer->render([HtmxCoreAttributes::swap->name => $strategy]);
    }

    /**
     * Renders `hx-trigger="event"`
     */
    public function trigger(string $event): string
    {
        return $this->renderer->render([HtmxCoreAttributes::trigger->name => $event]);
    }

    /**
     * Renders `hx-indicator="#selector"`
     */
    public function indicator(string $selector): string
    {
        return $this->renderer->render([HtmxAdditionalAttributes::indicator->name => $selector]);
    }

    /**
     * Renders `hx-on:event="handler"`
     */
    public function on(string $event, string $handler): string
    {
        return $this->renderer->render([HtmxCoreAttributes::on->name => [$event => $handler]]);
    }
}
