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

namespace BlackForest\Contao\AccessibleTabs\Elements;

/**
 * This trait is for the accessible tabs content elements.
 */
trait AccessibleTabsTrait
{
    /**
     * Generate the content element.
     *
     * @return string
     */
    public function generate(): string
    {
        // Do nothing here.
        return '';
    }

    /**
     * Generate the content element with the parent generate method.
     *
     * @return string
     */
    public function parentGenerate(): string
    {
        return parent::generate();
    }

    /**
     * Compile the content element.
     *
     * @return void
     */
    protected function compile(): void
    {
        // Do nothing here.
    }
}
