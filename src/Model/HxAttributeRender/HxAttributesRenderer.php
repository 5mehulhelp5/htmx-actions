<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Model\HxAttributeRender;

use MageHx\HtmxActions\Data\HxAttributesData;
use MageHx\HtmxActions\Data\MageUrlData;
use MageHx\HtmxActions\Enums\HtmxAdditionalAttributes;
use MageHx\HtmxActions\Enums\HtmxCoreAttributes;
use Magento\Framework\Escaper;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Framework\UrlInterface;

class HxAttributesRenderer
{
    public function __construct(
        private readonly Escaper $escaper,
        private readonly UrlInterface $urlBuilder,
        private readonly JsonSerializer $jsonSerializer,
    ) {
    }

    /**
     * Renders HTMX attributes from the given associative array, including default values
     * and special handling for event bindings via "hx-on".
     */
    public function render(array $hxAttributes): string
    {
        $attributesHtml = '';

        foreach ($this->toArray($hxAttributes) as $hxAttribute => $hxAttributeValue) {
            $attributesHtml .= " {$hxAttribute}=\"{$hxAttributeValue}\"";
        }

        return trim($attributesHtml);
    }

    public function toArray(array $hxAttributes): array
    {
        $hxAttributesData = HxAttributesData::from($hxAttributes);
        $nonNullAttributes = array_filter(get_object_vars($hxAttributesData), fn ($value) => $value !== null);

        $attributesArray = [];

        foreach ($nonNullAttributes as $attribute => $value) {
            if ($attribute === HtmxCoreAttributes::on->name) {
                // Render each event binding as hx-on:event="handler"
                foreach ($value as $event => $handler) {
                    $attributesArray["hx-on:{$event}"] = $handler;
                }
            } else {
                $hxAttribute = $this->resolveHxAttribute($attribute);
                $attributesArray[$hxAttribute] = $this->resolveValue($attribute, $value);
            }
        }

        return $attributesArray;
    }

    /**
     * Resolves the proper value for a given HTMX attribute.
     * For URLs, uses Magento's URL builder. Otherwise, escapes the value for safe HTML output.
     */
    private function resolveValue(string $attribute, mixed $value): string
    {
        return match ($attribute) {
            HtmxCoreAttributes::get->name,
            HtmxCoreAttributes::post->name => $this->resolveUrlValue($value),
            HtmxCoreAttributes::swap->name => $value->value,
            HtmxCoreAttributes::vals->name => $this->escaper->escapeHtmlAttr($this->jsonSerializer->serialize($value)),
            default => $value,
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
