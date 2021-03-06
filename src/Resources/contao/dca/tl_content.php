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

use BlackForest\Contao\AccessibleTabs\EventListener\Table\Content\AddNewElementListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Table\Content\AddSeparatorPropertyListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Table\Content\ShowJsLibraryHintListener;
use BlackForest\Contao\AccessibleTabs\EventListener\Table\Content\UniqueTabIdListener;
use BlackForest\Contao\AccessibleTabs\Formatter\Table\Content\ElementFormatter;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * Extend the data container content.
 */

/*
  * Config
  */

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][]   = [AddSeparatorPropertyListener::class, 'onAddProperty'];
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][]   = [ShowJsLibraryHintListener::class, 'onGenerate'];
$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][]   = [ElementFormatter::class, 'onInitialize'];
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = [AddNewElementListener::class, 'onAddNewElement'];

/*
 * Add palettes.
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['accessible_tabs_start'] = '';
PaletteManipulator::create()
    ->addLegend('type_legend', '', PaletteManipulator::POSITION_APPEND)
    ->addField(['type'], '', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_start_legend', 'type_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['headline'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_separator_legend', 'accessible_tabs_start_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['accessible_tabs_title', 'accessible_tabs_anchor'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_base_legend', 'accessible_tabs_separator_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(
            [
                'accessible_tabs_tabhead',
                'accessible_tabs_position',
                'accessible_tabs_syncheights',
                'accessible_tabs_save_state',
                'accessible_tabs_auto_anchor',
                'accessible_tabs_responsive',
                'accessible_tabs_css_class_available',
                'accessible_tabs_pagination',
                'accessible_tabs_current_info_text'
            ],
            '',
            PaletteManipulator::POSITION_APPEND
        )
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_fx_legend', 'accessible_tabs_base_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(
            [
                'accessible_tabs_fx',
                'accessible_tabs_fxspeed',
            ],
            '',
            PaletteManipulator::POSITION_APPEND
        )
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_selectors_legend', 'accessible_tabs_fx_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(
            [
                'accessible_tabs_wrapper_class',
                'accessible_tabs_current_info_class',
                'accessible_tabs_current_info_position',
                'accessible_tabs_tabhead_class',
                'accessible_tabs_tabbody',
                'accessible_tabs_list_class',
                'accessible_tabs_first_nav_item_class',
                'accessible_tabs_last_nav_item_class',
                'accessible_tabs_responsive_toggler_class',
                'accessible_tabs_clearfix_class'
            ],
            '',
            PaletteManipulator::POSITION_APPEND
        )
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('protected_legend', 'accessible_tabs_fx_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['protected'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('expert_legend', 'protected_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['cssID', 'space'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_start', 'tl_content')

    ::create()
        ->addLegend('invisible_legend', 'expert_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['invisible', 'start', 'stop'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_start', 'tl_content');


$GLOBALS['TL_DCA']['tl_content']['palettes']['accessible_tabs_separator'] = '';
PaletteManipulator::create()
    ->addLegend('type_legend', '', PaletteManipulator::POSITION_APPEND)
    ->addField(['type'], '', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('accessible_tabs_separator', 'tl_content')

    ::create()
        ->addLegend('accessible_tabs_separator_legend', 'type_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['accessible_tabs_title', 'accessible_tabs_anchor'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_separator', 'tl_content')

    ::create()
        ->addLegend('protected_legend', 'accessible_tabs_separator_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['protected'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_separator', 'tl_content')

    ::create()
        ->addLegend('expert_legend', 'protected_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['cssID', 'space'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_separator', 'tl_content')

    ::create()
        ->addLegend('invisible_legend', 'expert_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['invisible', 'start', 'stop'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_separator', 'tl_content');

$GLOBALS['TL_DCA']['tl_content']['palettes']['accessible_tabs_stop'] = '';
PaletteManipulator::create()
    ->addLegend('type_legend', '', PaletteManipulator::POSITION_APPEND)
    ->addField(['type'], '', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('accessible_tabs_stop', 'tl_content')

    ::create()
        ->addLegend('protected_legend', 'type_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['protected'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_stop', 'tl_content')

    ::create()
        ->addLegend('invisible_legend', 'expert_legend', PaletteManipulator::POSITION_APPEND, true)
        ->addField(['invisible', 'start', 'stop'], '', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('accessible_tabs_stop', 'tl_content');

/*
 * Add fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields'] = array_merge(
    $GLOBALS['TL_DCA']['tl_content']['fields'],
    [
        'accessible_tabs_type' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_type'],
            'default'           => '',
            'exclude'           => true,
            'inputType'         => 'radio',
            'options'           => ['Start', 'Separator', 'Stop'],
            'reference'         => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_type'],
            'eval'              => [
                'helpwizard'            => true,
                'submitOnChange'        => true,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_tabhead' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('tabhead'),
            'exclude'           => true,
            'inputType'         => 'select',
            'options'           => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            'reference'         => &$GLOBALS['TL_LANG']['tl_accessible_tabs'],
            'eval'              => [
                'tl_class'              => 'w50',
                'chosen'                => true,
                'disabled'              => false,
                'mandatory'             => true,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_position' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_position'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('position'),
            'exclude'           => true,
            'inputType'         => 'select',
            'options'           => ['top', 'bottom'],
            'reference'         => &$GLOBALS['TL_LANG']['tl_accessible_tabs'],
            'eval'              => [
                'includeBlankOption'    => false,
                'tl_class'              => 'w50',
                'chosen'                => false,
                'disabled'              => false,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_syncheights' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_syncheights'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('syncheights'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              =>'w50'
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_save_state' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_save_state'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('saveState'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_auto_anchor' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_auto_anchor'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('autoAnchor'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_responsive' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('responsive'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              => 'w50'
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_responsive_toggle_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_responsive_toggle_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('responsiveToggleClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_css_class_available' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_css_class_available'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('cssClassAvailable'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_pagination' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_pagination'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('pagination'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              =>'w50',
                'disabled'              =>false
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_fx' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fx'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('fx'),
            'exclude'           => true,
            'inputType'         => 'select',
            'options'           => ['show', 'fadeIn'],
            'reference'         => &$GLOBALS['TL_LANG']['tl_content'],
            'eval'              => [
                'includeBlankOption'    => false,
                'tl_class'              =>'w50',
                'chosen'                => true,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''",
        ],
        'accessible_tabs_fxspeed' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_fxspeed'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('fxspeed'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_wrapper_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrapper_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('wrapperClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_current_info_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('currentInfoClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_current_info_text' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_text_field'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('currentInfoText'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_current_info_position' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_current_info_position'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('currentInfoPosition'),
            'exclude'           => true,
            'inputType'         => 'select',
            'options'           => ['prepend', 'append'],
            'reference'         => &$GLOBALS['TL_LANG']['tl_accessible_tabs'],
            'eval'              => [
                'includeBlankOption'    => false,
                'tl_class'              => 'w50',
                'chosen'                => false,
                'disabled'              => false,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_tabhead_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabhead_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('tabheadClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_tabbody' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabbody'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('tabbody'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_tabs_list_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_tabs_list_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('tabsListClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_first_nav_item_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_first_nav_item_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('firstNavItemClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_last_nav_item_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_last_nav_item_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('lastNavItemClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_clearfix_class' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_clearfix_class'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('clearfixClass'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_wrap_inner_nav_links' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_wrap_inner_nav_links'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('wrapInnerNavLinks'),
            'exclude'           => true,
            'inputType'         => 'checkbox',
            'eval'              => [
                'tl_class'              => 'w50',
                'disabled'              => false
            ],
            'sql'               => "char(1) NOT NULL default ''"
        ],
        'accessible_tabs_sync_height_method_name' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_sync_height_method_name'],
            'default'           => \Contao\System::getContainer()->get('cb.accessible_tabs.data.default_settings')->get('syncHeightMethodName'),
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_title' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_title'],
            'exclude'           => true,
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'mandatory'             => true,
                'maxlength'             => 255
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_anchor' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_anchor'],
            'exclude'           => true,
            'load_callback'     => [[UniqueTabIdListener::class, 'onGenerate']],
            'save_callback'     => [[UniqueTabIdListener::class, 'onGenerate']],
            'inputType'         => 'text',
            'eval'              => [
                'tl_class'              => 'w50',
                'maxlength'             => 255,
                'doNotCopy'             => true
            ],
            'sql'               => "varchar(255) NOT NULL default ''"
        ],
        'accessible_tabs_add_separator' => [
            'label'             => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_add_separator'],
            'exclude'           => true,
            'inputType'         => 'cb.accessible_tabs.be_ffl_mcw_nsi',
            'eval'              => [
                'mandatory'             => true,
                'tl_class'              => 'w50',
                'columnFields'          => [
                    'separator'                 => [
                        'label'                         => &$GLOBALS['TL_LANG']['tl_content']['accessible_tabs_add_separator_separator'],
                        'exclude'                       => true,
                        'inputType'                     => 'text',
                        'eval'                          => [
                            'style'                             => 'width:100%',
                            'mandatory'                         => true
                        ]
                    ]
                ]
            ]
        ]
    ]
);
