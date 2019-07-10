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

namespace BlackForest\Contao\AccessibleTabs\Test\DependencyInjection;

use BlackForest\Contao\AccessibleTabs\DependencyInjection\BlackForestContaoAccessibleTabsExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers \BlackForest\Contao\AccessibleTabs\DependencyInjection\BlackForestContaoAccessibleTabsExtension
 */
class BlackForestContaoAccessibleTabsExtensionTest extends TestCase
{
    public function testAlias(): void
    {
        $extension = new BlackForestContaoAccessibleTabsExtension();

        $this->assertSame('black_forest_contao_accessible_tabs', $extension->getAlias());
    }

    public function testLoad(): void
    {
        $container = $this
            ->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(
                [
                    'fileExists'
                ]
            )
            ->getMock();
        $extension = new BlackForestContaoAccessibleTabsExtension();

        $extension->load([], $container);

        $this->assertTrue($container->fileExists($bar = \dirname(__DIR__, 2) . '/src/Resources/config/services.yml'));
    }
}
