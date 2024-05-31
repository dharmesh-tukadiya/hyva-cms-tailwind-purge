<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Observer;

use Magento\Framework\Event\ObserverInterface;

class CMSPageDelete implements ObserverInterface
{
    private $CMSPageDelete;
    public function __construct(
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSPageDelete $CMSPageDelete
    ) {
        $this->CMSPageDelete = $CMSPageDelete;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $page = $observer->getObject();
        if (is_object($page) && $page->getId()) {
            $this->CMSPageDelete->delete(['page' => $page]);
        }
    }
}
