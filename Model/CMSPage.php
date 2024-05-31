<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Model;

use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use \Magento\Cms\Model\PageRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use DnTukadiya\HyvaCMSTailwindPurge\Model\PurgeDirectories;

class CMSPage
{
    public const CMS_PAGE_DIRECTORY = 'CmsPage';
    protected $directoryList;
    protected $file;
    protected $pageRepository;
    protected $messageManager;
    public function __construct(
        DirectoryList $directoryList,
        File $file,
        PageRepository $pageRepository,
        ManagerInterface $messageManager
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->pageRepository = $pageRepository;
        $this->messageManager = $messageManager;
    }
    /**
     * @param array $params
     */
    public function create(array $params): array
    {
        /** @var \Magento\Cms\Model\Page $page  */

        $page = $params['page'] ?? null;
        $id = $params['id'] ?? null;
        if (is_object($page) && empty($page->getId())) {
            try {
                $page = $this->pageRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                return ['success' => false, 'message' => __('Could not add cms page to css purge. Page not found!!')];
            }
        }
        if ($page->getId()) {
            try {
                $folderPath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::PUB) . '/' . PurgeDirectories::MAIN_DIRECTORY . '/' . self::CMS_PAGE_DIRECTORY;
                $this->file->checkAndCreateFolder($folderPath);
                $filePath = $folderPath . '/' . $page->getId() . '.html';
                $content = $page->getContent();
                if (empty($content)) {
                    $content = "__EMPTY__";
                }
                if ($this->file->write($filePath, $content)) {
                    return ['success' => true, 'message' => __('Page successfully purged for Tailwind CSS!')];
                } else {
                    return ['success' => false, 'message' => __('Could not write to the file')];
                }
            } catch (\Exception $e) {
                return ['success' => false, 'message' => __($e->getMessage())];
            }
        } else {
            return ['success' => false, 'message' => __('Page Could Not be loaded!!')];
        }
    }
    public function getRespectedFolderPath(): string
    {
        return $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::PUB) . '/' . PurgeDirectories::MAIN_DIRECTORY . '/' . self::CMS_PAGE_DIRECTORY;
    }
}
