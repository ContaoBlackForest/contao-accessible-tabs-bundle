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

/**
 * This generates the unique tab id.
 */
class UniqueTabIdListener
{
    /**
     * Generate the unique id.
     *
     * @param string $value The property value.
     *
     * @return string
     */
    public function onGenerate(string $value): string
    {
        if ($value) {
            return $value;
        }

        return \uniqid('tab_', false);
    }
}
