<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Controller\Context;

use MageHx\HtmxActions\Controller\Result\HtmxRawFactory as HtmxResultRawFactory;
use MageHx\HtmxActions\Model\EventDispatcher;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class HtmxActionContext
{
    public function __construct(
        public Context $magentoAppActionContext,
        public readonly LayoutFactory $layoutFactory,
        public readonly EventDispatcher $eventDispatcher,
        public readonly HtmxResultRawFactory $rawFactory,
    ) {
    }
}
