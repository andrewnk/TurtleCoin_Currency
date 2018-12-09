<?php

namespace TurtleCoin\Currency\Setup;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * Increases column size for currency_from and currency_to to allow for 4 character currencies like TRTL
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $table = 'directory_currency_rate';
        $installer->startSetup();

        if ($installer->getConnection()->tableColumnExists($table, 'currency_from') && $installer->getConnection()->tableColumnExists($table, 'currency_to')) {

            $installer->getConnection()->modifyColumn(
                $setup->getTable($table),
                'currency_from',
                [
                    'type'      => Table::TYPE_TEXT,
                    'length'    => 4,
                    'default'   => NULL
                ]
            );

            $installer->getConnection()->modifyColumn(
                $setup->getTable($table),
                'currency_to',
                [
                    'type'      => Table::TYPE_TEXT,
                    'length'    => 4
                ]
            );
        }

        $installer->endSetup();
    }
}
