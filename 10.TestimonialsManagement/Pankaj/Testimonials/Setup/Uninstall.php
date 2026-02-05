<?php
namespace Pankaj\Testimonials\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    /**
     * Uninstall script
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Identify the table name used in your module
        $tableName = $setup->getTable('pankaj_testimonials');

        if ($setup->tableExists($tableName)) {
            // Drop the table if it exists
            $setup->getConnection()->dropTable($tableName);
        }

        $setup->endSetup();
    }
}
