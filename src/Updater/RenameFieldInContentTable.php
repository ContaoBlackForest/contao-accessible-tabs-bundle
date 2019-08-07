<?php

/**
 * This file is part of contaoblackforest/contao-accessible-tabs-bundle.
 *
 * (c) 2019 The Contao Blackforest team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    contaoblackforest/contao-accessible-tabs-bundle
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2019 The Contao Blackforest team.
 * @license    https://github.com/contaoblackforest/contao-accessible-tabs-bundle/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

declare(strict_types=1);

namespace BlackForest\Contao\AccessibleTabs\Updater;

use Contao\System;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\TableDiff;

/**
 * This handle the update for renaming fields in the content table.
 */
class RenameFieldInContentTable
{
    /**
     * The doctrine dbal connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->connection = System::getContainer()->get('database_connection');
    }

    /**
     * Handle the update.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->renameCurrentClass();
    }

    /**
     * Rename accessible_tabs_current_class => accessible_tabs_current_info_class
     *
     * @return void
     */
    private function renameCurrentClass(): void
    {
        $manager = $this->connection->getSchemaManager();
        $columns = $manager->listTableColumns('tl_content');
        if (!\array_key_exists('accessible_tabs_current_class', $columns)) {
            return;
        }

        $oldColumn = $columns['accessible_tabs_current_class'];
        $newColumn = $this->cloneColumn('accessible_tabs_current_info_class', $oldColumn);

        $this->renameColumn($oldColumn, $newColumn);
    }

    /**
     * Rename the column.
     *
     * @param Column $oldColumn
     * @param Column $newColumn
     *
     * @return void
     */
    private function renameColumn(Column $oldColumn, Column $newColumn): void
    {
        $manager = $this->connection->getSchemaManager();

        $columnDiff = new ColumnDiff($oldColumn->getName(), $newColumn);
        $tableDiff  = new TableDiff('tl_content', [], [$columnDiff]);

        $manager->alterTable($tableDiff);
    }

    /**
     * Clone a column.
     *
     * @param string $columnName The name for the new column.
     * @param Column $column     The source column.
     *
     * @return Column
     */
    private function cloneColumn(string $columnName, Column $column): Column
    {
        $newColumn = new Column($columnName, $column->getType());
        $newColumn
            ->setLength($column->getLength())
            ->setPrecision($column->getPrecision())
            ->setScale($column->getScale())
            ->setUnsigned($column->getUnsigned())
            ->setFixed($column->getFixed())
            ->setNotnull($column->getNotnull())
            ->setDefault($column->getDefault())
            ->setDefault($column->getDefault())
            ->setAutoincrement($column->getAutoincrement())
            ->setPlatformOptions($column->getPlatformOptions())
            ->setColumnDefinition($column->getColumnDefinition())
            ->setComment($column->getComment())
            ->setCustomSchemaOptions($column->getCustomSchemaOptions());

        return $newColumn;
    }
}
