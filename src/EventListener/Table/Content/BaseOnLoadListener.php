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

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The base onload callback listener has common methods.
 */
trait BaseOnLoadListener
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Evaluate the request.
     *
     * @return bool
     */
    private function evaluateRequest(): bool
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request
               && $request->query->has('act')
               && \in_array($request->query->get('act'), ['create', 'edit']);
    }
}
