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

namespace BlackForest\Contao\AccessibleTabs\EventListener\Backend;

use BlackForest\Contao\AccessibleTabs\Formatter\Table\Content\ElementFormatter;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The content element listener for the accessible tabs start element in the backend scope.
 */
trait BackendAccessibleTabsTrait
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The scope matcher.
     *
     * @var ScopeMatcher
     */
    private $scopeMatcher;

    /**
     * The element formatter.
     *
     * @var ElementFormatter
     */
    private $formatter;

    /**
     * The constructor.
     *
     * @param RequestStack     $requestStack The request stack.
     * @param ScopeMatcher     $scopeMatcher The scope matcher.
     * @param ElementFormatter $formatter    The element formatter.
     */
    public function __construct(RequestStack $requestStack, ScopeMatcher $scopeMatcher, ElementFormatter $formatter)
    {
        $this->requestStack = $requestStack;
        $this->scopeMatcher = $scopeMatcher;
        $this->formatter    = $formatter;
    }
}
