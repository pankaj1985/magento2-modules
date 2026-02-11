<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);

namespace Pankaj\LogViewer\Model\Log;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Pankaj\LogViewer\Helper\Data as LogViewerHelper;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Magento\Framework\App\RequestInterface;

class DataProvider extends AbstractDataProvider
{
    protected $request;
    protected $ioFile;
    protected $directoryList;
    protected $fileDriver;
    protected $logViewerHelper;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DirectoryList $directoryList
     * @param File $fileDriver
     * @param LogViewerHelper $logViewerHelper
     * @param IoFile $ioFile
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        DirectoryList $directoryList,
        File $fileDriver,
        LogViewerHelper $logViewerHelper,
        IoFile $ioFile,
        RequestInterface $request, // Fixed: Added request here
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->directoryList   = $directoryList;
        $this->request         = $request;
        $this->fileDriver      = $fileDriver;
        $this->logViewerHelper = $logViewerHelper;
        $this->ioFile          = $ioFile;
    }

    public function getData(): array
    {
        if (!$this->logViewerHelper->isEnabled()) {
            return ['totalRecords' => 0, 'items' => []];
        }

        $logDir       = $this->directoryList->getPath(DirectoryList::LOG);
        $allowedFiles = $this->logViewerHelper->getAllowedFiles();
        $items        = [];
        $id           = 1;

        try {
            if ($this->fileDriver->isExists($logDir)) {
                $files = $this->fileDriver->readDirectory($logDir);
                foreach ($files as $filePath) {
                    
                    // Sahi logic: loop mein aane wali file ka naam nikalna
                    $pathInfo = $this->ioFile->getPathInfo($filePath);
                    $fileName = $pathInfo['basename'] ?? '';

                    // Filter: Log file check and extension check
                    if ($this->fileDriver->isFile($filePath) && strpos($filePath, '.log') !== false) {
                        // Check if allowed list is empty (show all) OR if file is in allowed list
                        if (empty($allowedFiles) || in_array($fileName, $allowedFiles)) {
                            $fileStats = $this->fileDriver->stat($filePath);

                            $items[] = [
                                'id_field'   => $id++,
                                'file_name'  => $fileName,
                                'file_size'  => number_format($fileStats['size'] / 1024, 2) . ' KB',
                                'updated_at' => date("Y-m-d H:i:s", $fileStats['mtime'])
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return ['totalRecords' => 0, 'items' => []];
        }

        return [
            'totalRecords' => count($items),
            'items'        => array_values($items),
        ];
    }
}