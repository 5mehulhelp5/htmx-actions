<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Model\HxAttributeRender;

use MageHx\HtmxActions\Data\MageUrlData;
use MageHx\HtmxActions\Enums\HtmxAdditionalAttributes;
use MageHx\HtmxActions\Enums\HtmxCoreAttributes;
use MageHx\MahxCheckout\Data\CheckoutHxAttributesData;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;

class HxAttributesRenderer
{
    public function __construct(
        private readonly Escaper $escaper,
        private readonly UrlInterface $urlBuilder,
    ) {
    }

    /**
     * Renders HTMX attributes from the given associative array, including default values
     * and special handling for event bindings via "hx-on".
     */
    public function render(array $hxAttributes): string
    {
        $hxAttributesData = CheckoutHxAttributesData::from($hxAttributes);
        $nonNullAttributes = array_filter(get_object_vars($hxAttributesData), fn ($value) => $value !== null);

        $attributesHtml = '';

        foreach ($nonNullAttributes as $attribute => $value) {
            if ($attribute === HtmxCoreAttributes::on->name && is_array($value)) {
                // Render each event binding as hx-on:event="handler"
                foreach ($value as $event => $handler) {
                    $eventAttr = "hx-on:$event";
                    $eventValue = $this->escaper->escapeHtmlAttr($handler);
                    $attributesHtml .= " {$eventAttr}=\"{$eventValue}\"";
                }
            } else {
                $hxAttribute = $this->resolveHxAttribute($attribute);
                $resolvedValue = $this->resolveValue($attribute, $value);
                $attributesHtml .= " {$hxAttribute}=\"{$resolvedValue}\"";
            }
        }

        return trim($attributesHtml);
    }

    /**
     * Resolves the proper value for a given HTMX attribute.
     * For URLs, uses Magento's URL builder. Otherwise escapes the value for safe HTML output.
     */
    private function resolveValue(string $attribute, mixed $value): string
    {
        return match ($attribute) {
            HtmxCoreAttributes::get->name,
            HtmxCoreAttributes::post->name => $this->resolveUrlValue($value),
            default => $this->escaper->escapeHtmlAttr((string) $value),
        };
    }

    /**
     * Generates a URL using Magento's URL builder.
     * Supports raw strings or MageUrlData objects (with optional params).
     */
    private function resolveUrlValue(mixed $value): string
    {
        $path = $value instanceof MageUrlData ? $value->path : (string) $value;
        $params = $value instanceof MageUrlData ? $value->params : [];

        return $this->urlBuilder->getUrl(ltrim($path, '/'), array_merge($params, ['_secure' => true]));
    }

    /**
     * Resolves the proper HTMX attribute name by checking against core and additional attributes.
     * Falls back to raw name if not matched in enum.
     */
    private function resolveHxAttribute(string $attribute): string
    {
        return 'hx-' . (
                HtmxCoreAttributes::tryFrom($attribute)?->value
                ?? HtmxAdditionalAttributes::tryFrom($attribute)?->value
                ?? $attribute
            );
    }
}
