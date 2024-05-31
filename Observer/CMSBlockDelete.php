<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Observer;

use Magento\Framework\Event\ObserverInterface;

class CMSBlockDelete implements ObserverInterface
{
    private $CMSBlockDelete;
    public function __construct(
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSBlockDelete $CMSBlockDelete
    ) {
        $this->CMSBlockDelete = $CMSBlockDelete;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getObject();
        if (is_object($block) && $block->getId()) {
            $this->CMSBlockDelete->delete(['block' => $block]);
        }
    }
}
