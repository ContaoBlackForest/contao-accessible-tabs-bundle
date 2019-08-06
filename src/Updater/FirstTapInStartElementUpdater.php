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

/**
 * This handle the update the first tap in the start element.
 */
class FirstTapInStartElementUpdater
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
        if (!($startElements = $this->fetchAllStartElements())) {
            return;
        }

        $this->update($startElements);
    }

    /**
     * Update the elements.
     *
     * @param array $startElements The start elements.
     *
     * @return void
     */
    private function update(array $startElements): void
    {
        $platform = $this->connection->getDatabasePlatform();
        foreach ($startElements as $startElement) {
            if (!($separatorElement = $this->fetchSeparatorElementAfterStartElement($startElement))) {
                continue;
            }

            $update = [];
            if (!$startElement->accessible_tabs_title || $startElement->accessible_tabs_anchor) {
                $update = [
                    $platform->quoteIdentifier('accessible_tabs_title')  => $separatorElement->accessible_tabs_title,
                    $platform->quoteIdentifier('accessible_tabs_anchor') => $separatorElement->accessible_tabs_anchor
                ];
            }
            if (!\count($update)) {
                continue;
            }

            $this->connection->update(
                $platform->quoteIdentifier('tl_content'),
                $update,
                [
                    $platform->quoteIdentifier('id') => $startElement->id
                ]
            );
            $this->connection->delete(
                $platform->quoteIdentifier('tl_content'),
                [
                    $platform->quoteIdentifier('id') => $separatorElement->id
                ]
            );
        }
    }

    /**
     * Fetch the separator who is directly after the start element.
     *
     * @param \stdClass $startElement The start element.
     *
     * @return \stdClass|null
     */
    private function fetchSeparatorElementAfterStartElement(\stdClass $startElement): ?\stdClass
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id',
                'c.pid',
                'c.ptable',
                'c.type',
                'c.sorting',
                'c.accessible_tabs_title',
                'c.accessible_tabs_anchor'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere($builder->expr()->gt('c.sorting', ':start'))
            ->setParameter(':identifier', $startElement->pid)
            ->setParameter(':ptable', $startElement->ptable)
            ->setParameter(':start', $startElement->sorting)
            ->orderBy('c.sorting')
            ->setMaxResults(1);

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        $element = $statement->fetch(\PDO::FETCH_OBJ);
        if ('accessible_tabs_separator' !== $element->type) {
            return null;
        }

        return $element;
    }

    /**
     * Fetch all start elements.
     *
     * @return array|null
     */
    private function fetchAllStartElements(): ?array
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select('c.*')
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.type', ':startType'))
            ->setParameter(':startType', 'accessible_tabs_start');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}
