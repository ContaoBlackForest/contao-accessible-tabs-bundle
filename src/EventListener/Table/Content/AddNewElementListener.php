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

namespace BlackForest\Contao\AccessibleTabs\EventListener\Table\Content;

use Contao\Database\Result;
use Contao\DataContainer;
use Contao\Encryption;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This add the new elements (separator, stop) after the start element is created.
 */
class AddNewElementListener
{
    use BaseOnLoadListener;

    /**
     * The doctrine dbal connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * The session.
     *
     * @var Session
     */
    private $session;

    /**
     * ShowJsLibraryHintListener constructor.
     *
     * @param Connection   $connection   The doctrine dbal connection.
     * @param RequestStack $requestStack The request stack.
     * @param Session      $session      The session.
     */
    public function __construct(
        Connection $connection,
        RequestStack $requestStack,
        Session $session
    ) {
        $this->connection   = $connection;
        $this->requestStack = $requestStack;
        $this->session      = $session;
    }

    /**
     * Add the new elements.
     *
     * @param DataContainer $container The data container.
     *
     * @return void
     */
    public function onAddNewElement(DataContainer $container): void
    {
        $request = $this->requestStack->getCurrentRequest();

        /** @var AttributeBagInterface $sessionBag */
        if (!$container->activeRecord
            || !$request->request->has('accessible_tabs_add_separator')
            || !$this->evaluateRequest()
            || !($sessionBag = $this->session->getBag('contao_backend'))
            || !($newRecords = $sessionBag->get('new_records'))
            || !\array_key_exists('tl_content', $newRecords)
            || !\in_array($container->id, $newRecords['tl_content'], true)
        ) {
            return;
        }

        $afterElements = $this->fetchAllElementAfterElementBySorting($container->activeRecord);
        $sorting       = ($container->activeRecord->sorting + 128);

        $this->addSeparator($container->activeRecord, $sorting);
        $this->addEndElement($container->activeRecord, $sorting);

        if (!$afterElements) {
            $this->updateSession($sessionBag, $container, $newRecords);

            return;
        }

        $this->updateSorting($afterElements, $sorting);
        $this->updateSession($sessionBag, $container, $newRecords);
    }

    /**
     * Add the separator.
     *
     * @param Result $result  The result.
     * @param int    $sorting The sorting.
     *
     * @return void
     */
    private function addSeparator(Result $result, int &$sorting): void
    {
        $request  = $this->requestStack->getCurrentRequest();
        $platform = $this->connection->getDatabasePlatform();


        foreach (\array_column($request->request->get('accessible_tabs_add_separator'), 'separator') as $separator) {
            $properties = $this->getEmptyProperties();

            $properties['pid']                    = $result->pid;
            $properties['tstamp']                 = \time();
            $properties['ptable']                 = $result->ptable;
            $properties['sorting']                = $sorting;
            $properties['type']                   = 'accessible_tabs_separator';
            $properties['accessible_tabs_title']  = $separator;
            $properties['accessible_tabs_anchor'] = (new UniqueTabIdListener())->onGenerate('');

            $insert = [];
            foreach ($properties as $property => $value) {
                $insert[$platform->quoteIdentifier($property)] = $value;
            }

            $this->connection->insert($platform->quoteIdentifier('tl_content'), $insert);

            $sorting += 128;
        }
    }

    /**
     * Add the end element.
     *
     * @param Result $result  The result.
     * @param int    $sorting The sorting.
     *
     * @return void
     */
    private function addEndElement(Result $result, int &$sorting): void
    {
        $platform   = $this->connection->getDatabasePlatform();
        $properties = $this->getEmptyProperties();

        $properties['pid']     = $result->pid;
        $properties['tstamp']  = \time();
        $properties['ptable']  = $result->ptable;
        $properties['sorting'] = $sorting;
        $properties['type']    = 'accessible_tabs_stop';

        $insert = [];
        foreach ($properties as $property => $value) {
            $insert[$platform->quoteIdentifier($property)] = $value;
        }

        $this->connection->insert($platform->quoteIdentifier('tl_content'), $insert);

        $sorting += 128;
    }

    /**
     * Update the sorting for the elements.
     *
     * @param array $elements The element list.
     * @param int   $sorting  The sorting.
     *
     * @return void
     */
    private function updateSorting(array $elements, int $sorting): void
    {
        $platform = $this->connection->getDatabasePlatform();

        foreach ($elements as $element) {
            $this->connection->update(
                $platform->quoteIdentifier('tl_content'),
                [
                    $platform->quoteIdentifier('sorting') => $sorting
                ],
                [
                    $platform->quoteIdentifier('id') => $element->id
                ]
            );

            $sorting += 128;
        }
    }

    /**
     * Get the properties with their default value.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function getEmptyProperties(): array
    {
        $properties = [];
        foreach ($GLOBALS['TL_DCA']['tl_content']['fields'] as $propert => $config) {
            if (\array_key_exists('default', $config)) {
                $properties[$propert] =
                    \is_array($config['default']) ? \serialize($config['default']) : $config['default'];

                if ($GLOBALS['TL_DCA']['tl_content']['fields'][$propert]['eval']['encrypt']) {
                    $properties[$propert] = Encryption::encrypt($properties[$propert]);
                }
            }
        }

        return $properties;
    }

    /**
     * Update the new records key in the session.
     *
     * @param AttributeBagInterface $sessionBag The session bag.
     * @param DataContainer         $container  The data container.
     * @param array                 $newRecords The new record list.
     *
     * @return void
     */
    private function updateSession(AttributeBagInterface $sessionBag, DataContainer $container, array $newRecords): void
    {
        unset($newRecords['tl_content'][\array_flip($newRecords['tl_content'])[$container->id]]);

        if (empty($newRecords['tl_content'])) {
            unset($newRecords['tl_content']);
        }

        if (empty($newRecords)) {
            $sessionBag->remove('new_records');
        }

        $sessionBag->set('new_records', $newRecords);
    }

    /**
     * Fetch all element after element by sorting.
     *
     * @param Result $result The element.
     *
     * @return array|null
     */
    private function fetchAllElementAfterElementBySorting(Result $result): ?array
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere($builder->expr()->gt('c.sorting', ':start'))
            ->setParameter(':identifier', $result->pid)
            ->setParameter(':ptable', $result->ptable)
            ->setParameter(':start', $result->sorting)
            ->orderBy('c.sorting');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}
