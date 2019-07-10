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
 * @license    https://github.com/contaoblackforest/contaoblackforest/contao-accessible-tabs-bundle/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

declare(strict_types=1);

namespace BlackForest\Contao\AccessibleTabs\Test;

use BlackForest\Contao\AccessibleTabs\BlackForestContaoAccessibleTabsBundle;
use BlackForest\Contao\AccessibleTabs\DependencyInjection\BlackForestContaoAccessibleTabsExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers \BlackForest\Contao\AccessibleTabs\BlackForestContaoAccessibleTabsBundle
 */
class BlackForestContaoAccessibleTabsBundleTest extends TestCase
{
    public function testBundle(): void
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();

        $bundle = new BlackForestContaoAccessibleTabsBundle();
        $bundle->build($container);

        $this->assertSame('BlackForestContaoAccessibleTabsBundle', $bundle->getName());
        $this->assertSame('BlackForest\Contao\AccessibleTabs', $bundle->getNamespace());
        $this->assertSame(\dirname(__DIR__) . '/src', $bundle->getPath());
        $this->assertInstanceOf(BlackForestContaoAccessibleTabsExtension::class, $bundle->getContainerExtension());
    }
}
