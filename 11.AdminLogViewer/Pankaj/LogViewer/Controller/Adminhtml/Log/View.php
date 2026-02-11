<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Pankaj\LogViewer\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Registry;
use Pankaj\LogViewer\Helper\Data as LogViewerHelper;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class View to display log content
 */
class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var DirectoryList
     */
    protected $directoryList;
    
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var LogViewerHelper
     */
    protected $logViewerHelper;

    /**
     * @var FileDriver
     */
    protected $fileDriver;

    /**
     * @var IoFile
     */
    protected $ioFile;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param DirectoryList $directoryList
     * @param Registry $coreRegistry
     * @param LogViewerHelper $logViewerHelper
     * @param FileDriver $fileDriver
     * @param IoFile $ioFile
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DirectoryList $directoryList,
        Registry $coreRegistry,
        LogViewerHelper $logViewerHelper,
        FileDriver $fileDriver,
        IoFile $ioFile
    ) {
        parent::__construct($context); // Sirf context pass karein parent ko
        $this->resultPageFactory = $resultPageFactory;
        $this->directoryList = $directoryList;
        $this->coreRegistry = $coreRegistry;
        $this->logViewerHelper = $logViewerHelper;
        $this->fileDriver = $fileDriver;
        $this->ioFile = $ioFile;
    }

    /**
     * View log file content
     *
     * @return ResultInterface
     */
    public function execute()
    {
        if (!$this->logViewerHelper->isEnabled()) {
            $this->messageManager->addErrorMessage(__('This feature is not available right now.'));
            return $this->resultRedirectFactory->create()->setPath('adminhtml/dashboard/index');
        }

        // Fix for "basename() is discouraged"
        $rawFile = (string)$this->getRequest()->getParam('file');
        $pathInfo = $this->ioFile->getPathInfo($rawFile);
        $fileName = $pathInfo['basename'] ?? '';

        $logDir = $this->directoryList->getPath(DirectoryList::LOG);
        $filePath = $logDir . DIRECTORY_SEPARATOR . $fileName;
        $fetchTotalLines = (int)$this->logViewerHelper->getLogLines();

        try {
            if (!$this->fileDriver->isExists($filePath)) {
                $this->messageManager->addErrorMessage(__('File not found.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }

            $content = $this->readLastLines($filePath, $fetchTotalLines);
            
            // phpcs:ignore Magento2.Legacy.CoreRegistry
            $this->coreRegistry->register('log_content', $content);
            // phpcs:ignore Magento2.Legacy.CoreRegistry
            $this->coreRegistry->register('log_file_name', $fileName);

            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__("Viewing Log: %1", $fileName));
            return $resultPage;

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Error reading log: %1", $e->getMessage()));
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }
    }

    /**
     * Efficiently read the last N lines of a file using Magento File Driver
     *
     * @param string $file
     * @param int $lines
     * @return string
     */
    private function readLastLines($file, $lines)
    {
        try {
            $stat = $this->fileDriver->stat($file);
            $size = $stat['size'] ?? 0;

            if ($size === 0) {
                return (string)__("File is empty.");
            }

            $handle = $this->fileDriver->fileOpen($file, "r");
            $this->fileDriver->fileSeek($handle, 0, SEEK_END);
            $pos = $size;
            $text = "";
            $count = 0;

            while ($pos > 0 && $count < $lines) {
                $this->fileDriver->fileSeek($handle, --$pos);
                $char = $this->fileDriver->fileGetc($handle);
                if ($char === "\n") {
                    $count++;
                }
                $text = $char . $text;
            }
            $this->fileDriver->fileClose($handle);
            return $text;
        } catch (\Exception $e) {
            return "Could not read file: " . $e->getMessage();
        }
    }
}
