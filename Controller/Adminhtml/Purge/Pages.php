<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Controller\Adminhtml\Purge;

use Magento\Framework\Message\ManagerInterface;

class Pages extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'DnTukadiya_HyvaCMSTailwindPurge::cms_page_tailwind';
    protected $resultRedirectFactory;
    protected $messageManager;
    protected $pageCollectionFactory;
    protected $cmsPurgeModel;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ManagerInterface $messageManager,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSPage $cmsPurgeModel
    ) {
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->messageManager = $messageManager;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->cmsPurgeModel = $cmsPurgeModel;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            \Magento\Framework\Filesystem\Io\File::rmdirRecursive($this->cmsPurgeModel->getRespectedFolderPath());
            $pages = $this->pageCollectionFactory->create();
            $errorFound = false;
            foreach ($pages as $page) {
                $response = $this->cmsPurgeModel->create(['page' => $page]);
                if (!$response['success']) {
                    $errorFound = true;
                    $this->messageManager->addErrorMessage($response['message']);
                }
            }
            if (!$errorFound) {
                $this->messageManager->addSuccessMessage('Purged Pages Successfully!!');
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setRefererUrl();
        return $resultRedirect;
    }
}
