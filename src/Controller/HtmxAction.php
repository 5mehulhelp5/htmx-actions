<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Controller;

use MageHx\HtmxActions\Controller\Context\HtmxActionContext;
use MageHx\HtmxActions\Model\EventDispatcher;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\RawFactory as ControllerResultRawFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\LayoutInterface;

abstract class HtmxAction extends Action
{
    private EventDispatcher $eventDispatcher;

    protected string $blockName = '';
    protected array $handles = [];
    protected array $layouts = [];
    protected array $blocks = [];

    public function __construct(
        HtmxActionContext $context,
    ) {
        parent::__construct($context->magentoAppActionContext);
        $this->eventDispatcher = $context->eventDispatcher;
    }

    public function getBlockResponse(
        ?string $blockName = null,
        ?array $handles = null,
        string $additionalHtml = ''
    ): ResultInterface {
        $beforeTransport = $this->eventDispatcher->dispatchBlockResponseBefore([
            'block_name' => $blockName ?? $this->blockName,
            'handles' => $handles ?? $this->handles,
            'additional_html' => $additionalHtml,
            'full_action_name' => $this->getRequest()->getFullActionName(),
        ]);

        $blockName = $beforeTransport->getData('block_name');
        $handles = $beforeTransport->getData('handles');
        $html = $this->getBlock($blockName, $handles)?->toHtml() ?? '';
        $response = $this->rawFactory->create()->setContents($html . $additionalHtml);

        $afterTransport = $this->eventDispatcher->dispatchBlockResponseAfter([
            'response' => $response,
            'full_action_name' => $this->getRequest()->getFullActionName(),
        ]);

        return $afterTransport->getData('response');
    }

    public function getMultiBlockResponse(array $blockNames, ?array $handles = null): ResultInterface
    {
        $beforeTransport = $this->eventDispatcher->dispatchMultiBlockResponseBefore([
            'block_names' => $blockNames,
            'handles' => $handles,
            'full_action_name' => $this->getRequest()->getFullActionName(),
        ]);

        $html = '';
        $blockNames = $beforeTransport->getData('block_names');
        $handles = $beforeTransport->getData('handles');

        foreach ($blockNames as $blockName) {
            $html .= $this->renderBlockToHtml($blockName, $handles);
        }

        $response = $this->rawFactory->create()->setContents($html);

        $afterTransport = $this->eventDispatcher->dispatchMultiBlockResponseAfter([
            'response' => $response,
            'full_action_name' => $this->getRequest()->getFullActionName(),
        ]);

        return $afterTransport->getData('response');
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

    protected function getBlock(string $blockName, array $handles, array $data = []): ?BlockInterface
    {
        if (isset($this->blocks[$blockName])) {
            return $this->blocks[$blockName];
        }

        $layout = $this->loadLayoutFromHandles($handles);
        $block = $layout->getBlock($blockName);

        foreach ($data as $key => $value) {
            $block->setData($key, $value);
        }

        return $this->blocks[$blockName] = $block;
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
