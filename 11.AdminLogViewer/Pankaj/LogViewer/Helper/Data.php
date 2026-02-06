<?php
namespace Pankaj\LogViewer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * Helper class to fetch module configuration settings
 */
class Data extends AbstractHelper
{
    /**
     * Configuration path prefix
     */
    const XML_PATH_LOGVIEWER = 'logviewer/general/';

    /**
     * Get system configuration value
     *
     * @param string $field
     * @param int|string|null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_LOGVIEWER . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if the module is enabled
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->getConfigValue('enabled', $storeId);
    }

    /**
     * Get number of log lines to display
     *
     * @param int|string|null $storeId
     * @return int
     */
    public function getLogLines($storeId = null): int
    {
        $lines = $this->getConfigValue('lines_count', $storeId);
        return $lines ? (int)$lines : 50; // Providing default 50 lines
    }

    /**
     * Get array of allowed log files
     *
     * @param int|string|null $storeId
     * @return array
     */
    public function getAllowedFiles($storeId = null): array
    {
        $files = $this->getConfigValue('allowed_files', $storeId);
        if (!$files) {
            return [];
        }
        // If multiselect provides data as string, convert to array
        return is_array($files) ? $files : explode(',', $files);
    }
}