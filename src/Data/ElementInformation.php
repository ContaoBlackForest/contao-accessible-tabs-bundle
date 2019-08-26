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

namespace BlackForest\Contao\AccessibleTabs\Data;

use Contao\DataContainer;
use Contao\Model;
use Doctrine\DBAL\Connection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

/**
 * The data store who has information of the tab elements.
 */
class ElementInformation
{
    /**
     * The doctrine dbal connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * The elements.
     *
     * @var array
     */
    private $elements;

    /**
     * The sorted elements.
     *
     * @var array
     */
    private $sorted;

    /**
     * ElementFormatter constructor.
     *
     * @param Connection $connection The doctrine dbal connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get the information for the wrapper start element.
     *
     * @param Model $model The model.
     *
     * @return \stdClass|null
     */
    public function getStartElementInformation(Model $model): ?\stdClass
    {
        $this->initialize($model);

        if (!($element = $this->elements[$model->id])) {
            return null;
        }

        $sortedElements = $this->sorted[$element->sortedIndex];

        return \array_values($sortedElements)[0];
    }

    /**
     * Initialize the elements information.
     *
     * @param Model $model The model.
     *
     * @return void
     */
    private function initialize(Model $model): void
    {
        if ($this->elements
            || !($elements = $this->fetchAllStartAndEndElement((int) $model->pid, (string) $model->ptable))
        ) {
            return;
        }

        $this->addSortedElements($elements);
        $this->addSubElements();
    }

    /**
     * Add the sorted elements.
     *
     * @param array $elements The elements.
     *
     * @return void
     */
    private function addSortedElements(array $elements): void
    {
        $index         = 0;
        $startElements = [];
        foreach ($elements as $element) {
            $this->elements[$element->id] = $element;

            if ('accessible_tabs_start' === $element->type) {
                $index++;
                $startElements[$index]                   = $element;
                $this->sorted[$index][$element->sorting] = $element;

                continue;
            }

            if (('accessible_tabs_stop' === $element->type)
                && 1 === \count($this->sorted[$index])
            ) {
                $this->sorted[$index][$element->sorting] = $element;

                unset($startElements[$index]);

                continue;
            }

            $backwardIndex = \array_slice(\array_keys($startElements), -1, 1)[0];

            $this->sorted[$backwardIndex][$element->sorting] = $element;

            unset($startElements[$backwardIndex]);
        }
    }

    /**
     * Add the sub elements.
     *
     * @return void
     */
    private function addSubElements(): void
    {
        foreach ($this->sorted as $index => $elements) {
            if (1 === \count($elements)) {
                $singleElement = \array_pop($elements);

                if ($this->elements[$singleElement->id]) {
                    $singleElement = $this->elements[$singleElement->id];
                }

                $singleElement->sortedIndex = $index;

                continue;
            }

            if (2 !== \count($elements)) {
                continue;
            }

            $endElement   = \array_pop($elements);
            $startElement = \array_pop($elements);

            if ($this->elements[$startElement->id]) {
                $startElement = $this->elements[$startElement->id];
            }
            if ($this->elements[$endElement->id]) {
                $endElement = $this->elements[$endElement->id];
            }

            $startElement->sortedIndex = $index;
            $endElement->sortedIndex   = $index;

            $subElements = $this->fetchAllInSortingRange(
                (int) $startElement->sorting,
                (int) $endElement->sorting,
                (int) $startElement->pid,
                $startElement->ptable
            );

            $sorted                            = [];
            $sorted[$startElement->sorting]    = $startElement;
            $this->elements[$startElement->id] = $startElement;
            if (!$subElements) {
                $sorted[$endElement->sorting] = $endElement;

                $this->sorted[$index] = $sorted;

                continue;
            }

            $this->addSortedSubElements($subElements, $index, $sorted);

            $sorted[$endElement->sorting] = $endElement;

            $this->sorted[$index] = $sorted;
        }
    }

    /**
     * Add the sorted sub elements.
     *
     * @param array $subElements The sub elements.
     * @param int   $index       The index.
     * @param array $sorted      The sorted elements.
     *
     * @return void
     */
    private function addSortedSubElements(array $subElements, int $index, array &$sorted): void
    {
        foreach ($subElements as $subElement) {
            $sorted[$subElement->sorting]    = $subElement;
            $subElement->sortedIndex         = $index;
            $this->elements[$subElement->id] = $subElement;
        }
    }

    /**
     * Fetch all elements in the sorting range.
     *
     * @param int    $start       The start index.
     * @param int    $end         The end index.
     * @param int    $pid         The parent id.
     * @param string $parentTable The parent table.
     *
     * @return array|null
     */
    private function fetchAllInSortingRange(int $start, int $end, int $pid, string $parentTable): ?array
    {
        // Round timestamp to full minute full minute
        $time = (\time() - (\time() % 60));

        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id',
                'c.pid',
                'c.ptable',
                'c.type',
                'c.sorting',
                'c.accessible_tabs_title',
                'c.accessible_tabs_anchor',
                'c.accessible_tabs_tabhead',
                'c.accessible_tabs_tabbody',
                'c.accessible_tabs_wrapper_class'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->setParameter(':identifier', $pid)
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere($builder->expr()->gt('c.sorting', ':start'))
            ->andWhere($builder->expr()->lt('c.sorting', ':end'))
            ->andWhere($builder->expr()->eq('c.invisible', ':empty'))
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.start', ':empty'),
                    $builder->expr()->lte('c.start', ':startTime')
                )
            )
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.stop', ':empty'),
                    $builder->expr()->gt('c.stop', ':stopTime')
                )
            )
            ->setParameter(':ptable', $parentTable)
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->setParameter(':empty', '')
            ->setParameter(':startTime', $time)
            ->setParameter(':stopTime', ($time + 60))
            ->orderBy('c.sorting');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Fetch all start and end element.
     *
     * @param int    $identifier  The parent element id.
     * @param string $parentTable The parent table.
     *
     * @return array|null
     */
    private function fetchAllStartAndEndElement(int $identifier, string $parentTable): ?array
    {
        // Round timestamp to full minute full minute
        $time = (\time() - (\time() % 60));

        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id',
                'c.pid',
                'c.ptable',
                'c.type',
                'c.sorting',
                'c.accessible_tabs_title',
                'c.accessible_tabs_anchor',
                'c.accessible_tabs_tabhead',
                'c.accessible_tabs_tabbody',
                'c.accessible_tabs_wrapper_class'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.type', ':startType'),
                    $builder->expr()->eq('c.type', ':endType')
                )
            )
            ->andWhere($builder->expr()->eq('c.invisible', ':empty'))
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.start', ':empty'),
                    $builder->expr()->lte('c.start', ':startTime')
                )
            )
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.stop', ':empty'),
                    $builder->expr()->gt('c.stop', ':stopTime')
                )
            )
            ->setParameter(':identifier', $identifier)
            ->setParameter(':ptable', $parentTable)
            ->setParameter(':startType', 'accessible_tabs_start')
            ->setParameter(':endType', 'accessible_tabs_stop')
            ->setParameter(':empty', '')
            ->setParameter(':startTime', $time)
            ->setParameter(':stopTime', ($time + 60))
            ->orderBy('c.sorting');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}
