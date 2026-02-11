<?php
namespace Pankaj\LogViewer\Controller\Adminhtml\Log;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Registry;
use Pankaj\LogViewer\Helper\Data as LogViewerHelper;

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
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * View constructor.
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param DirectoryList $directoryList
     * @param Registry $coreRegistry
     * @param LogViewerHelper $logViewerHelper
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        DirectoryList $directoryList,
        Registry $coreRegistry,
        LogViewerHelper $logViewerHelper
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->directoryList = $directoryList;
        $this->coreRegistry = $coreRegistry;
        $this->logViewerHelper = $logViewerHelper;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
    }

    /**
     * View log file content
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        if (!$this->logViewerHelper->isEnabled()) {
            $this->messageManager->addErrorMessage(__('This feature is not available right now.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('adminhtml/dashboard/index');
        }

        $fileName = $this->getRequest()->getParam('file');
        $logDir = $this->directoryList->getPath(DirectoryList::LOG);
        $filePath = $logDir . '/' . $fileName;
        $fecthTotalLines = $this->logViewerHelper->getLogLines();

        if (!file_exists($filePath)) {
            $this->messageManager->addErrorMessage(__('File not found.'));
            return $this->_redirect('*/*/index');
        }

        $content = $this->readLastLines($filePath, $fecthTotalLines); 
        
        $this->coreRegistry->register('log_content', $content);
        $this->coreRegistry->register('log_file_name', $fileName);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__("Viewing Log: %1", $fileName));
        return $resultPage;
    }

    /**
     * Efficiently read the last N lines of a file
     *
     * @param string $file
     * @param int $lines
     * @return string
     */
    private function readLastLines($file, $lines) {
        if (filesize($file) == 0) return "File is empty.";
        
        $handle = fopen($file, "r");
        fseek($handle, 0, SEEK_END);
        $pos = ftell($handle);
        $text = "";
        $count = 0;

        while ($pos > 0 && $count < $lines) {
            fseek($handle, --$pos);
            $char = fgetc($handle);
            if ($char == "\n") $count++;
            $text = $char . $text;
        }
        fclose($handle);
        return $text;
    }
}