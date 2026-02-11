<?php
/**
 * Copyright © Pankaj Sharma. All rights reserved.
 */
declare(strict_types=1);
namespace Pankaj\LogViewer\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\Io\File as IoFile;

/**
 * Class Options
 * Source model to fetch all available .log files from the var/log directory
 */
class Options implements OptionSourceInterface
{

    /**
     * @var IoFile
     */
    protected $ioFile;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var File
     */
    protected $fileDriver;

    /**
     * Options constructor.
     *
     * @param DirectoryList $directoryList
     * @param File $fileDriver
     * @param IoFile $ioFile
     */
    public function __construct(
        DirectoryList $directoryList,
        File $fileDriver,
        IoFile $ioFile
    ) {
        $this->directoryList = $directoryList;
        $this->fileDriver = $fileDriver;
        $this->ioFile = $ioFile;
    }

    /**
     * Return array of log files as options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        
        $logDir = $this->directoryList->getPath(DirectoryList::LOG);
        $options = [];

        try {
            if ($this->fileDriver->isExists($logDir)) {
                $files = $this->fileDriver->readDirectory($logDir);
                foreach ($files as $filePath) {
                    
                    // Check if it's a file and has .log extension
                    if ($this->fileDriver->isFile($filePath) && strpos($filePath, '.log') !== false) {
                        
                        $pathInfo = $this->ioFile->getPathInfo($filePath);
                        
                        $fileName = $pathInfo['basename'] ?? '';
                        $options[] = [
                            'value' => $fileName,
                            'label' => $fileName
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            // Error handling in case of directory permission issues
            return [['value' => '', 'label' => __('Error reading log directory')]];
        }

        return $options;
    }
}
