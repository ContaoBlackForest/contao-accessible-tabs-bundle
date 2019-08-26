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

use BlackForest\Contao\AccessibleTabs\Elements\IAccessibleTabs;
use Contao\ContentElement;
use Contao\Frontend;
use Contao\Model;

/**
 * The content element listener for the accessible tabs content element in the backend scope.
 */
class BackendAccessibleTabsContentListener
{
    use BackendAccessibleTabsTrait;

    /**
     * Get the content element.
     *
     * @param Model                   $model   The model.
     * @param string                  $content The content.
     * @param Frontend|ContentElement $element The element.
     *
     * @return string
     */
    public function onGetContentElement(Model $model, string $content, Frontend $element): string
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
