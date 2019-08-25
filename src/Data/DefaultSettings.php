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

namespace BlackForest\Contao\AccessibleTabs\Data;

/**
 * The default settings.
 */
class DefaultSettings
{
    /**
     * The default settings.
     *
     * @var array
     */
    private $settings = [];

    /**
     * Has a setting.
     *
     * @param string $name The setting name.
     *
     * @return mixed
     */
    public function has(string $name): bool
    {
        $this->warmUpSettings();

        return \array_key_exists($name, $this->settings);
    }

    /**
     * Get a setting.
     *
     * @param string $name The setting name.
     *
     * @return mixed
     */
    public function get(string $name)
    {
        $this->warmUpSettings();

        return ($this->settings[$name] ?? null);
    }

    /**
     * Warm up the settings.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function warmUpSettings(): void
    {
        if (\count($this->settings)) {
            return;
        }

        $settingKeys = \preg_grep('/^accessible_tabs_/', \array_keys($GLOBALS['TL_CONFIG']));

        foreach ($settingKeys as $settingKey) {
            $settingName = \str_replace(
                '_',
                '',
                \lcfirst(\ucwords(\substr($settingKey, \strlen('accessible_tabs_')), '_'))
            );

            $this->settings[$settingName] = $GLOBALS['TL_CONFIG'][$settingKey];
        }
    }
}
