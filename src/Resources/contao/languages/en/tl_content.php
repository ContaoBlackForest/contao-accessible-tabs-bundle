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


/*
 * Fields start
 */

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead'][0]                  = 'Element heading';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead'][1]                  = 'This element is transformed into the navigation.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_position'][0]                 = 'Positioning of the Navigation';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_position'][1]                 = 'Defines the position to be inserted into the navigation.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_syncheights'][0]              = 'Adjust height';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_syncheights'][1]              = 'Adjusts the height of the individual elements to the largest.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_save_state'][0]               = 'Save state';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_save_state'][1]               = 'The active tab is stored in a cookie (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_auto_anchor'][0]              = 'Linkable externally';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_auto_anchor'][1]              = 'The tab can be accessed directly via the hash tag (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_pagination'][0]               = 'Pagination';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_pagination'][1]               = 'Activates the Forward and Back buttons (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_css_class_available'][0]      = 'Assigning individual classes';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_css_class_available'][1]      = 'Assigns freely definable classes to each navigation point (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive'][0]               = 'Responsive behavior';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive'][1]               = 'Allows you to convert the tabs of small screens into a menu.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx'][0]                       = 'Transition effect';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx'][1]                       = 'Defines the animation type when switching between tabs (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fxspeed'][0]                  = 'Transition effect Duration';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fxspeed'][1]                  = 'The duration of the transition effect - possible values [normal|fast|slow] or ms (jQuery only).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrapper_class'][0]            = 'Class: Overlapping DIV';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrapper_class'][1]            = 'Class name of the DIV element wrapping around the original content.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_class'][0]            = 'Class: current tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_class'][1]            = 'This class is added to the active navigation element.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_position'][0]    = 'Position of the info';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_position'][1]    = 'Determines whether the information is output before or after the tab.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead_class'][0]            = 'Class: Tab Name';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead_class'][1]            = 'This class is added to the previously defined heading tag.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabbody'][0]                  = 'Class: Tab Body';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabbody'][1]                  = 'This class is added to the body of each tab.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabs_list_class'][0]          = 'Class: Tab List';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabs_list_class'][1]          = 'This class is assigned to the tab surrounding UL element.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive_toggler_class'][0] = 'Class: Mobile Toggler';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive_toggler_class'][1] = 'This class is assigned to the UL element when the menu is open.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_first_nav_item_class'][0]     = 'Class: First Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_first_nav_item_class'][1]     = 'This class is assigned to the first LI element.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_last_nav_item_class'][0]      = 'Class: Last Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_last_nav_item_class'][1]      = 'This class is assigned to the last LI element.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_clearfix_class'][0]           = 'Class: clearfix';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_clearfix_class'][1]           = 'This class allows you to use your own class for the Clearfix.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrap_inner_nav_links'][0]     = 'jQuery: wrapinner';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrap_inner_nav_links'][1]     = 'See jQuery documentation http://api.jquery.com/wrapInner.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_sync_height_method_name'][0]  = 'SyncHeights method';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_sync_height_method_name'][1]  = 'Defines the SyncHeights JS class.';

/*
 * Fields separator
 */

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_title'][0]  = 'Tab title';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_title'][1]  = 'Defines the navigation text.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_anchor'][0] = 'Tab ID';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_anchor'][1] = 'The ID is used to externally link the tabs e.g. [href="index.php#tab_xxx]" (jQuery only).';


/*
 * Legends
 */

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_start_legend']     = 'Headline';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_base_legend']      = 'Default settings';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx_legend']        = 'Transition effects';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_separator_legend'] = 'Separator';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_misc_legend']      = 'Miscellaneous';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_break_legend']     = 'Tab settings';


$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_text'] = 'Aktuelles Tab:';
