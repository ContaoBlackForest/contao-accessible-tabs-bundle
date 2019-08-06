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

use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsSeparator;
use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsStart;
use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsStop;

/*
 * Content elements
 */

$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_start']     = AccessibleTabsStart::class;
$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_separator'] = AccessibleTabsSeparator::class;
$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_stop']      = AccessibleTabsStop::class;
