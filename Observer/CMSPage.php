<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Observer;

use Magento\Framework\Event\ObserverInterface;

class CMSPage implements ObserverInterface
{
    private $CMSPage;
    public function __construct(
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSPage $CMSPage
    ) {
        $this->CMSPage = $CMSPage;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $page = $observer->getObject();
        if (is_object($page) && $page->getId()) {
            $this->CMSPage->create(['page' => $page]);
        }
    }
}
