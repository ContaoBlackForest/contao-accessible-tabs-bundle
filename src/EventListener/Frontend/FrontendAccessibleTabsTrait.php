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

namespace BlackForest\Contao\AccessibleTabs\EventListener\Frontend;

use BlackForest\Contao\AccessibleTabs\Data\DefaultSettings;
use BlackForest\Contao\AccessibleTabs\Data\ElementInformation;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Model;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The content element listener for the accessible tabs start element in the frontend scope.
 */
trait FrontendAccessibleTabsTrait
{
    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The scope matcher.
     *
     * @var ScopeMatcher
     */
    private $scopeMatcher;

    /**
     * The default settings.
     *
     * @var DefaultSettings
     */
    private $defaultSettings;

    /**
     * The element information.
     *
     * @var ElementInformation
     */
    private $elementInformation;

    /**
     * The constructor.
     *
     * @param RequestStack       $requestStack       The request stack.
     * @param ScopeMatcher       $scopeMatcher       The scope matcher.
     * @param DefaultSettings    $defaultSettings    The default settings.
     * @param ElementInformation $elementInformation The element information.
     */
    public function __construct(
        RequestStack $requestStack,
        ScopeMatcher $scopeMatcher,
        DefaultSettings $defaultSettings,
        ElementInformation $elementInformation
    ) {
        $this->requestStack       = $requestStack;
        $this->scopeMatcher       = $scopeMatcher;
        $this->defaultSettings    = $defaultSettings;
        $this->elementInformation = $elementInformation;
    }

    /**
     * Get the accessible tab configuration from the model.
     *
     * @param Model $model The model.
     *
     * @return array
     */
    private function getTabConfigFromModel(Model $model): array
    {
        $data       = $model->row();
        $configKeys = \preg_grep('/^accessible_tabs_/', \array_keys($data));

        $config = [];
        foreach ($configKeys as $configKey) {
            $configName = \str_replace(
                '_',
                '',
                \lcfirst(\ucwords(\substr($configKey, \strlen('accessible_tabs_')), '_'))
            );

            $config[$configName] = $data[$configKey];
        }

        return $config;
    }
}
