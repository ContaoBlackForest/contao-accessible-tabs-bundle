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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This add the property for add separator.
 */
class AddSeparatorPropertyListener
{
    use BaseOnLoadListener;

    /**
     * The session.
     *
     * @var Session
     */
    private $session;

    /**
     * The constructor.
     *
     * @param RequestStack $requestStack The request stack.
     * @param Session      $session      The session.
     */
    public function __construct(RequestStack $requestStack, Session $session)
    {
        $this->requestStack = $requestStack;
        $this->session      = $session;
    }

    /**
     * Add the property to the legend.
     *
     * @param DataContainer $container The data container.
     *
     * @return void
     */
    public function onAddProperty(DataContainer $container): void
    {
        /** @var AttributeBagInterface $sessionBag */
        if (!$this->evaluateRequest()
            || !($sessionBag = $this->session->getBag('contao_backend'))
            || !($newRecords = $sessionBag->get('new_records'))
            || !\array_key_exists('tl_content', $newRecords)
            || !\in_array($container->id, $newRecords['tl_content'], true)
        ) {
            return;
        }

        PaletteManipulator::create()
            ->addLegend('accessible_tabs_separator_legend', '', PaletteManipulator::POSITION_APPEND)
            ->addField('accessible_tabs_add_separator', 'accessible_tabs_anchor')
            ->applyToPalette('accessible_tabs_start', 'tl_content');
    }
}
