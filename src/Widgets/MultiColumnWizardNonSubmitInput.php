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

namespace BlackForest\Contao\AccessibleTabs\Widgets;

use MenAtWork\MultiColumnWizardBundle\Contao\Widgets\MultiColumnWizard;

/**
 * This widget of multi column wizard not submit the input. So the value of this will not be save.
 */
class MultiColumnWizardNonSubmitInput extends MultiColumnWizard
{
    /**
     * Submit user input.
     *
     * @var boolean
     */
    protected $blnSubmitInput = false;
}
