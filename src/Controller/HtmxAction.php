<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\RawFactory as ControllerResultRawFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\View\Result\LayoutFactory;

abstract class HtmxAction extends Action
{
    protected string $blockName = '';
    protected array $handles = [];
    protected array $layouts = [];
    protected array $blocks = [];

    public function __construct(
        Context $context,
        private readonly LayoutFactory $layoutFactory,
        private readonly ControllerResultRawFactory $rawFactory,
    ) {
        parent::__construct($context);
    }

    public function getBlockResponse(?string $blockName = null, ?array $handles = null): ResultInterface
    {
        $html = $this->getBlock($blockName ?? $this->blockName, $handles ?? $this->handles)?->toHtml() ?? '';

        return $this->rawFactory->create()->setContents($html);
    }

    public function getMultiBlockResponse(array $blockNames, ?array $handles = null): ResultInterface
    {
        $html = '';

        foreach ($blockNames as $blockName) {
            $html .= $this->renderBlockToHtml($blockName, $handles);
        }

        return $this->rawFactory->create()->setContents($html);
    }

    public function getEmptyResponse(): ResultInterface
    {
        return $this->rawFactory->create();
    }

    public function setBlockName(string $blockName): self
    {
        $this->blockName = $blockName;
        return $this;
    }

    public function setHandles(array $handles): self
    {
        $this->handles = $handles;
        return $this;
    }

    protected function getPostData(?string $param = null, mixed $defaultValue = null): mixed
    {
        return $this->getRequest()->getPost($param, $defaultValue);
    }

    protected function renderBlockToHtml(?string $blockName = null, ?array $handles = null): string
    {
        return $this->getBlock($blockName ?? $this->blockName, $handles ?? $this->handles)?->toHtml() ?? '';
    }

    protected function getBlock(string $blockName, array $handles): ?BlockInterface
    {
        if (isset($this->blocks[$blockName])) {
            return $this->blocks[$blockName];
        }

        $layout = $this->loadLayoutFromHandles($handles);
        return $this->blocks[$blockName] = $layout->getBlock($blockName);
    }

    protected function loadLayoutFromHandles($handles): LayoutInterface
    {
        $layoutKey = implode('__', $handles);

        if (!isset($this->layouts[$layoutKey])) {
            $layoutResult = $this->layoutFactory->create();
            $layout = $layoutResult->getLayout();

            foreach ($handles as $handle) {
                $layout->getUpdate()->addHandle($handle);
            }

            $layout->getUpdate()->load();
            $layout->generateXml();
            $layout->generateElements();

            $this->layouts[$layoutKey] = $layout;
        }

        return $this->layouts[$layoutKey];
    }
}
