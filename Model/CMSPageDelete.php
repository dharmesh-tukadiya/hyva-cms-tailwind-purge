<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Model;

use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Message\ManagerInterface;
use DnTukadiya\HyvaCMSTailwindPurge\Model\PurgeDirectories;

class CMSPageDelete
{
    public const CMS_PAGE_DIRECTORY = 'CmsPage';
    protected $directoryList;
    protected $file;
    protected $messageManager;
    public function __construct(
        DirectoryList $directoryList,
        File $file,
        ManagerInterface $messageManager
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->messageManager = $messageManager;
    }
    /**
     * @param array $params
     */
    public function delete(array $params): array
    {
        /** @var \Magento\Cms\Model\Page $page  */

        $page = $params['page'] ?? null;
        if ($page->getId()) {
            try {
                $folderPath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::PUB) . '/' . PurgeDirectories::MAIN_DIRECTORY . '/' . self::CMS_PAGE_DIRECTORY;
                $filePath = $folderPath . '/' . $page->getId() . '.html';
                if ($this->file->rm($filePath)) {
                    return ['success' => true, 'message' => __('`Purged Page` Successfully Deleted for Tailwind CSS!')];
                } else {
                    return ['success' => false, 'message' => __('Could not delete the `Purged Page` file!!')];
                }
            } catch (\Exception $e) {
                return ['success' => false, 'message' => __($e->getMessage())];
            }
        } else {
            return ['success' => false, 'message' => __('`Purged Page` Could Not be loaded for deletion!!')];
        }
    }
}
