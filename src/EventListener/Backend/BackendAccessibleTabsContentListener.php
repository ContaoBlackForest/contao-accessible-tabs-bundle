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

use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsSeparator;
use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsStart;
use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsStop;
use BlackForest\Contao\AccessibleTabs\Elements\IAccessibleTabs;
use BlackForest\Contao\AccessibleTabs\Formatter\Table\Content\ElementFormatter;
use Contao\ContentElement;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Model;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The content element listener for the accessible tabs content element in the backend scope.
 */
class BackendAccessibleTabsContentListener
{
    use BackendAccessibleTabsTrait;

    /**
     * Get the content element.
     *
     * @param Model          $model   The model.
     * @param string         $content The content.
     * @param ContentElement $element The element.
     *
     * @return string
     */
    public function onGetContentElement(Model $model, string $content, ContentElement $element): string
    {
        if (($element instanceof IAccessibleTabs)
            || !($request = $this->requestStack->getCurrentRequest())
            || !$this->scopeMatcher->isBackendRequest($request)
        ) {
            return $content;
        }

        if (!($formattedContent = $this->formatter->format($model))) {
            return $content;
        }

        return \str_replace('##content_element##', $content, $formattedContent);
    }
}
