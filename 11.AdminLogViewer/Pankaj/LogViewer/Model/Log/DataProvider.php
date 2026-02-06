<?php
namespace Pankaj\LogViewer\Model\Log;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Pankaj\LogViewer\Helper\Data as LogViewerHelper;

/**
 * Class DataProvider
 * Custom DataProvider for the Log Viewer UI Component grid
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var File
     */
    protected $fileDriver;

    /**
     * @var LogViewerHelper
     */
    protected $logViewerHelper;

    /**
     * DataProvider constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DirectoryList $directoryList
     * @param File $fileDriver
     * @param LogViewerHelper $logViewerHelper
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
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->directoryList   = $directoryList;
        $this->fileDriver      = $fileDriver;
        $this->logViewerHelper = $logViewerHelper;
    }

    /**
     * Get Log Data for UI Component Grid
     *
     * @return array
     */
    public function getData(): array
    {
        // Check if module is enabled before processing
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
                    $fileName = basename($filePath);

                    // Filter: Check if file is in allowed list and has .log extension
                    if ($this->fileDriver->isFile($filePath) && strpos($filePath, '.log') !== false) {
                        if (!empty($allowedFiles) && in_array($fileName, $allowedFiles)) {
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
            // Handle directory reading errors gracefully
            return ['totalRecords' => 0, 'items' => []];
        }

        return [
            'totalRecords' => count($items),
            'items'        => array_values($items),
        ];
    }
}