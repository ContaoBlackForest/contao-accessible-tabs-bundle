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
 * @license    https://github.com/contaoblackforest/contaoblackforest/contao-accessible-tabs-bundle/blob/master/LICENSE
 *             LGPL-3.0
 * @filesource
 */

declare(strict_types=1);

namespace BlackForest\Contao\AccessibleTabs\Test\ContaoManager;

use BlackForest\Contao\AccessibleTabs\BlackForestContaoAccessibleTabsBundle;
use BlackForest\Contao\AccessibleTabs\ContaoManager\Plugin;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \BlackForest\Contao\AccessibleTabs\ContaoManager\Plugin
 */
class PluginTest extends TestCase
{
    public function testGetBundles()
    {
        $parser = $this->createMock(ParserInterface::class);

        $plugin = new Plugin();

        /** @var BundleConfig[]|array $bundles */
        $bundles = $plugin->getBundles($parser);

        $this->assertCount(1, $bundles);

        $this->assertSame(BlackForestContaoAccessibleTabsBundle::class, $bundles[0]->getName());
        $this->assertTrue($bundles[0]->loadInProduction());
        $this->assertTrue($bundles[0]->loadInDevelopment());
        $this->assertSame([], $bundles[0]->getReplace());
        $this->assertSame([ContaoCoreBundle::class], $bundles[0]->getLoadAfter());
    }
}
