<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Observer;

use Magento\Framework\Event\ObserverInterface;

class CMSBlock implements ObserverInterface
{
    private $CMSBlock;
    public function __construct(
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSBlock $CMSBlock
    ) {
        $this->CMSBlock = $CMSBlock;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getObject();
        if (is_object($block) && $block->getId()) {
            $this->CMSBlock->create(['block' => $block]);
        }
    }
}
