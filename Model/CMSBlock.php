<?php

namespace DnTukadiya\HyvaCMSTailwindPurge\Model;

use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use \Magento\Cms\Model\BlockRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use DnTukadiya\HyvaCMSTailwindPurge\Model\PurgeDirectories;

class CMSBlock
{
    public const CMS_BLOCK_DIRECTORY = 'CmsBlock';
    protected $directoryList;
    protected $file;
    protected $blockRepository;
    protected $messageManager;
    public function __construct(
        DirectoryList $directoryList,
        File $file,
        BlockRepository $blockRepository,
        ManagerInterface $messageManager
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->blockRepository = $blockRepository;
        $this->messageManager = $messageManager;
    }
    /**
     * @param array $params
     */
    public function create(array $params): array
    {
        /** @var \Magento\Cms\Model\Block $block  */

        $block = $params['block'] ?? null;
        $id = $params['id'] ?? null;
        if (is_object($block) && empty($block->getId())) {
            try {
                $block = $this->blockRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                return ['success' => false, 'message' => __('Could not add cms block to css purge. Block not found!!')];
            }
        }
        if ($block->getId()) {
            try {
                $folderPath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::PUB) . '/' . PurgeDirectories::MAIN_DIRECTORY . '/' . self::CMS_BLOCK_DIRECTORY;
                $this->file->checkAndCreateFolder($folderPath);
                $filePath = $folderPath . '/' . $block->getId() . '.html';
                $content = $block->getContent();
                if ($this->file->write($filePath, $content)) {
                    return ['success' => true, 'message' => __('Block successfully purged for Tailwind CSS!')];
                } else {
                    return ['success' => false, 'message' => __('Could not write to the file')];
                }
            } catch (\Exception $e) {
                return ['success' => false, 'message' => __($e->getMessage())];
            }
        } else {
            return ['success' => false, 'message' => __('Block Could Not be loaded!!')];
        }
    }
    public function getRespectedFolderPath(): string
    {
        return $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::PUB) . '/' . PurgeDirectories::MAIN_DIRECTORY . '/' . self::CMS_BLOCK_DIRECTORY;
    }
}
