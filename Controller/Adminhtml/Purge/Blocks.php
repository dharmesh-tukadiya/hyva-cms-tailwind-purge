<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Controller\Adminhtml\Purge;

use Magento\Framework\Message\ManagerInterface;

class Blocks extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'DnTukadiya_HyvaCMSTailwindPurge::cms_block_tailwind';
    protected $resultRedirectFactory;
    protected $messageManager;
    protected $blockCollectionFactory;
    protected $cmsPurgeModel;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ManagerInterface $messageManager,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockCollectionFactory,
        \DnTukadiya\HyvaCMSTailwindPurge\Model\CMSBlock $cmsPurgeModel
    ) {
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->messageManager = $messageManager;
        $this->blockCollectionFactory = $blockCollectionFactory;
        $this->cmsPurgeModel = $cmsPurgeModel;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            \Magento\Framework\Filesystem\Io\File::rmdirRecursive($this->cmsPurgeModel->getRespectedFolderPath());
            $blocks = $this->blockCollectionFactory->create();
            $errorFound = false;
            foreach ($blocks as $block) {
                $response = $this->cmsPurgeModel->create(['block' => $block]);
                if (!$response['success']) {
                    $errorFound = true;
                    $this->messageManager->addErrorMessage($response['message']);
                }
            }
            if (!$errorFound) {
                $this->messageManager->addSuccessMessage('Purged Blocks Successfully!!');
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setRefererUrl();
        return $resultRedirect;
    }
}
