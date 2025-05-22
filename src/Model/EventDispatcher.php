<?php

declare(strict_types=1);

namespace MageHx\HtmxActions\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface as EventManager;

class EventDispatcher
{
    public function __construct(
        private readonly EventManager $eventManager,
    ) {
    }

    public function dispatchBlockResponseBefore(array $eventData): DataObject
    {
        $transport =  new DataObject($eventData);
        $this->eventManager->dispatch('hxactions_block_response_before', ['transport' => $transport]);

        return $transport;
    }

    public function dispatchBlockResponseAfter(array $eventData): DataObject
    {
        $transport =  new DataObject($eventData);
        $this->eventManager->dispatch('hxactions_block_response_after', ['transport' => $transport]);

        return $transport;
    }

    public function dispatchMultiBlockResponseBefore(array $eventData): DataObject
    {
        $transport =  new DataObject($eventData);
        $this->eventManager->dispatch('hxactions_multi_blocks_response_before', ['transport' => $transport]);

        return $transport;
    }

    public function dispatchMultiBlockResponseAfter(array $eventData): DataObject
    {
        $transport =  new DataObject($eventData);
        $this->eventManager->dispatch('hxactions_multi_blocks_response_after', ['transport' => $transport]);

        return $transport;
    }
}
