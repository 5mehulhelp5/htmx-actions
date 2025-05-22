<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\ViewModel;

use MageHx\HtmxActions\Model\HxAttributeRender\HxAttributeBuilder;
use MageHx\HtmxActions\Model\HxAttributeRender\HxAttributeBuilderFactory;
use MageHx\HtmxActions\Model\HxAttributeRender\HxAttributesRenderer as HxAttributesModelRenderer;
use MageHx\HtmxActions\Traits\ShorthandHxAttributesRenderers;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * ViewModel to render HTMX attributes (hx-post, hx-target, hx-on, etc.) from a structured data array.
 */
class HxAttributesRenderer implements ArgumentInterface
{
    use ShorthandHxAttributesRenderers;

    public function __construct(
        protected readonly HxAttributesModelRenderer $renderer,
        private readonly HxAttributeBuilderFactory $hxAttributeBuilderFactory,
    ) {
    }

    public function hxBuilder(): HxAttributeBuilder
    {
        return $this->hxAttributeBuilderFactory->create();
    }

    /**
     * Renders HTMX attributes from the given associative array, including default values
     * and special handling for event bindings via "hx-on".
     */
    public function render(array $hxAttributes): string
    {
        return $this->renderer->render($hxAttributes);
    }
}
