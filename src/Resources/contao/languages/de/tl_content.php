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

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead'][0]                  = 'Überschrift Element';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead'][1]                  = 'Dieses Element wird in die Navigation transformiert.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_position'][0]                 = 'Positionierung der Navigation';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_position'][1]                 = 'Definiert die Position an die Navigation eingefügt wird.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_syncheights'][0]              = 'Höhe anpassen';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_syncheights'][1]              = 'Passt die Höhe der einzelnen Elemente dem Grössten an.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_save_state'][0]               = 'Zustand sichern';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_save_state'][1]               = 'Das aktive Tab wird in einem Cookie hinterlegt (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_auto_anchor'][0]              = 'Von extern verlinkbar';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_auto_anchor'][1]              = 'Das Tab kann über den Hashtag direckt angesprungen werden (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_pagination'][0]               = 'Seitenumbruch';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_pagination'][1]               = 'Aktiviert die Vor- und Zurückschaltfläche (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_css_class_available'][0]      = 'Individuelle Klassen zuweisen';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_css_class_available'][1]      = 'Weist jedem Navigationspunkt frei definierbare Klassen zu (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive'][0]               = 'Responsives verhalten';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive'][1]               = 'Ermöglicht bei kleinen Screens die Tabs in ein Menu umzuwandeln.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx'][0]                       = 'Übergangseffekt';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx'][1]                       = 'Definiert den Animationstyp beim Wechsel zwischen den Tabs (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fxspeed'][0]                  = 'Übergangseffekt Dauer';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fxspeed'][1]                  = 'Die Dauer des Übergangeffektes - mögliche werte [normal|fast|slow] oder ms (nur jQuery).';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrapper_class'][0]            = 'Klasse: umschlagendes DIV';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrapper_class'][1]            = 'Klassenname der um den ursprünglichen Inhalt umschlagenden DIV Element.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_class'][0]       = 'Klasse: aktuelles Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_class'][1]       = 'Diese Klasse wird dem aktiven Navigationselement angefügt.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_position'][0]    = 'Position der Info';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_position'][1]    = 'Legt fest ob die Information vor oder nach dem Tab ausgegeben wird.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead_class'][0]            = 'Klasse: Tab Name';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead_class'][1]            = 'Diese Klasse wird dem zuvor definierten Heading Tags angefügt.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabbody'][0]                  = 'Klasse: Tab Body';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabbody'][1]                  = 'Diese Klasse wird dem Body der einzelnen Tabs angefügt.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabs_list_class'][0]          = 'Klasse: Tab Liste';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabs_list_class'][1]          = 'Diese Klasse wird dem Tab umgebendem UL Element zugewiesen.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive_toggler_class'][0] = 'Klasse: Mobile Toggler';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive_toggler_class'][1] = 'Diese Klasse wird dem UL Element zugewiesen wenn das Menü geöffnet ist.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_first_nav_item_class'][0]     = 'Klasse: Erstes Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_first_nav_item_class'][1]     = 'Diese Klasse wird dem ersten LI Element zugewiesen.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_last_nav_item_class'][0]      = 'Klasse: Letztes Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_last_nav_item_class'][1]      = 'Diese Klasse wird dem letzten LI Element zugewiesen.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_clearfix_class'][0]           = 'Klasse: Clearfix';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_clearfix_class'][1]           = 'Diese Klasse ermöglicht eine eigene Klasse für den Clearfix zu nutzen.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrap_inner_nav_links'][0]     = 'jQuery: wrapinner';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrap_inner_nav_links'][1]     = 'Siehe jQuery Dokumentation http://api.jquery.com/wrapInner.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_sync_height_method_name'][0]  = 'SyncHeights Methode';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_sync_height_method_name'][1]  = 'Definiert die SyncHeights JS Klasse.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_text_field'][0]  = 'Aktulles Tab';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_text_field'][1]  = 'Hier können Sie deb Text eingeben der vor der Überschrift des aktiven Tabs steht.';

/*
 * Fields separator
 */

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_title'][0]  = 'Titel des Tabs';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_title'][1]  = 'Definiert den Navigationstext.';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_anchor'][0] = 'Tab ID';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_anchor'][1] = 'Die ID wird verwendet um die Tabs von extern zu verlinken z.B. [href="index.php#tab_xxx]" (nur jQuery).';


/*
 * Legends
 */

$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_start_legend']     = 'Überschrift';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_base_legend']      = 'Grundeinstellungen';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx_legend']        = 'Übergangsefekte';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_separator_legend'] = 'Separator';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_selectors_legend'] = 'Selektoren';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_misc_legend']      = 'Verschiedenes';
$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_break_legend']     = 'Tab Einstellungen';
