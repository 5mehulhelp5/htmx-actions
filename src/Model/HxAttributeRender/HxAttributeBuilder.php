<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Model\HxAttributeRender;

use MageHx\HtmxActions\Enums\HtmxAdditionalAttributes;
use MageHx\HtmxActions\Enums\HtmxCoreAttributes;
use MageHx\HtmxActions\Enums\HtmxSwapOption;
use MageHx\HtmxActions\ViewModel\HxAttributesRenderer;

/**
 * Fluent builder for generating HTMX attributes.
 *
 * This class provides convenient shorthand methods for building a set of
 * common HTMX attributes (`hx-get`, `hx-post`, `hx-target`, etc.) and
 * rendering them using a central `HxAttributesRenderer`.
 *
 * Example usage:
 * ```
 * $builder->post('/submit')
 *         ->target('#form-result')
 *         ->swap('outerHTML')
 *         ->render();
 * ```
 */
class HxAttributeBuilder
{
    private array $attributes = [];

    public function __construct(
        private readonly HxAttributesRenderer $renderer,
    ) {
    }

    /**
     * Set the `hx-get` attribute.
     */
    public function get(string $path): self
    {
        $this->attributes[HtmxCoreAttributes::get->name] = $path;
        return $this;
    }

    /**
     * Set the `hx-post` attribute.
     */
    public function post(string $path): self
    {
        $this->attributes[HtmxCoreAttributes::post->name] = $path;
        return $this;
    }

    /**
     * Set the `hx-target` attribute.
     */
    public function target(string $target): self
    {
        $this->attributes[HtmxCoreAttributes::target->name] = $target;
        return $this;
    }

    public function targetThis(): self
    {
        $this->target('this');
        return $this;
    }

    /**
     * Set the `hx-swap` attribute.
     */
    public function swap(HtmxSwapOption $strategy): self
    {
        $this->attributes[HtmxCoreAttributes::swap->name] = $strategy;
        return $this;
    }

    public function swapOuterHTML(): self
    {
        $this->swap(HtmxSwapOption::outerHTML);
        return $this;
    }

    public function swapInnerHTML(): self
    {
        $this->swap(HtmxSwapOption::innerHTML);
        return $this;
    }

    /**
     * Set the `hx-trigger` attribute.
     */
    public function trigger(string $events): self
    {
        $this->attributes[HtmxCoreAttributes::trigger->name] = $events;
        return $this;
    }

    /**
     * Set the `hx-on:<event>` attribute.
     */
    public function on(string $event, string $handler): self
    {
        $this->attributes[HtmxCoreAttributes::on->name][$event] = $handler;
        return $this;
    }

    public function indicator(string $indicator): self
    {
        $this->attributes[HtmxAdditionalAttributes::indicator->name] = $indicator;
        return $this;
    }

    public function include(string|array $include): self
    {
        $includeArray = $include;

        if (is_string($include)) {
            $includeArray = explode(',', $include);
        }

        $this->attributes[HtmxAdditionalAttributes::include->name] = $includeArray;
        return $this;
    }

    public function vals(array $values): self
    {
        $this->attributes[HtmxCoreAttributes::vals->name] = $values;
        return $this;
    }

    public function when(bool $condition, callable $callback): self
    {
        if ($condition) {
            $callback($this);
        }

        return $this;
    }

    /**
     * Render the built attributes into a string using the configured renderer.
     */
    public function render(): string
    {
        return $this->renderer->render($this->attributes);
    }
}
