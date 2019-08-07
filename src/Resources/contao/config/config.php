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
use BlackForest\Contao\AccessibleTabs\EventListener\Backend\BackendAccessibleTabsContentListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Backend\BackendAccessibleTabsSeparatorListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Backend\BackendAccessibleTabsStartListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Backend\BackendAccessibleTabsStopListener;

/*
 * Content elements
 */

$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_start']     = AccessibleTabsStart::class;
$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_separator'] = AccessibleTabsSeparator::class;
$GLOBALS['TL_CTE']['accessible_tabs']['accessible_tabs_stop']      = AccessibleTabsStop::class;

/*
 * Wrapper elements
 *
 * It use own logic for add the backend style of the wrapper elements.
 */

$GLOBALS['TL_HOOKS']['getContentElement'][] = [BackendAccessibleTabsStartListener::class, 'onGetContentElement'];
$GLOBALS['TL_HOOKS']['getContentElement'][] = [BackendAccessibleTabsSeparatorListener::class, 'onGetContentElement'];
$GLOBALS['TL_HOOKS']['getContentElement'][] = [BackendAccessibleTabsStopListener::class, 'onGetContentElement'];
$GLOBALS['TL_HOOKS']['getContentElement'][] = [BackendAccessibleTabsContentListener::class, 'onGetContentElement'];

/*
 * The default settings.
 */

$GLOBALS['TL_CONFIG']['accessible_tabs_tabhead']                 = 'h4';
$GLOBALS['TL_CONFIG']['accessible_tabs_position']                = 'top';
$GLOBALS['TL_CONFIG']['accessible_tabs_syncheights']             = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_sync_height_method_name'] = 'syncHeight';
$GLOBALS['TL_CONFIG']['accessible_tabs_save_state']              = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_auto_anchor']             = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_pagination']              = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_responsive_toggle_class'] = 'open';
$GLOBALS['TL_CONFIG']['accessible_tabs_responsive']              = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_fx']                      = 'show';
$GLOBALS['TL_CONFIG']['accessible_tabs_fxspeed']                 = 'normal';
$GLOBALS['TL_CONFIG']['accessible_tabs_wrapper_class']           = 'content';
$GLOBALS['TL_CONFIG']['accessible_tabs_current_class']           = 'current';
$GLOBALS['TL_CONFIG']['accessible_tabs_tabhead_class']           = 'tabhead';
$GLOBALS['TL_CONFIG']['accessible_tabs_tabbody']                 = 'tabbody';
$GLOBALS['TL_CONFIG']['accessible_tabs_tabs_list_class']         = 'tabs-list';
$GLOBALS['TL_CONFIG']['accessible_tabs_first_nav_item_class']    = 'first';
$GLOBALS['TL_CONFIG']['accessible_tabs_last_nav_item_class']     = 'last';
$GLOBALS['TL_CONFIG']['accessible_tabs_clearfix_class']          = 'block';
$GLOBALS['TL_CONFIG']['accessible_tabs_css_class_available']     = false;
$GLOBALS['TL_CONFIG']['accessible_tabs_wrap_inner_nav_links']    = '';
$GLOBALS['TL_CONFIG']['accessible_tabs_sync_height_method_name'] = 'syncHeight';
$GLOBALS['TL_CONFIG']['accessible_tabs_current_info_position']   = 'prepend';
$GLOBALS['TL_CONFIG']['accessible_tabs_current_info_text']       = $GLOBALS['TL_LANG']['tl_accessible_tabs']['accessible_tabs_current_info_text'];
$GLOBALS['TL_CONFIG']['accessible_tabs_current_info_class']      = 'current-info';
