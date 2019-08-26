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

use BlackForest\Contao\AccessibleTabs\Elements\AccessibleTabsStart;
use Contao\ContentElement;
use Contao\Frontend;
use Contao\Model;

/**
 * The content element listener for the accessible tabs start element in the frontend scope.
 */
class FrontendAccessibleTabsStartListener
{
    use FrontendAccessibleTabsTrait;

    /**
     * Get the content element.
     *
     * @param Model                   $model   The model.
     * @param string                  $content The content.
     * @param Frontend|ContentElement $element The element.
     *
     * @return string
     */
    public function onGetContentElement(Model $model, string $content, Frontend $element): string
    {
        if (!($element instanceof AccessibleTabsStart)
            || !($request = $this->requestStack->getMasterRequest())
            || !$this->scopeMatcher->isFrontendRequest($request)
        ) {
            return $content;
        }

        $config = $data = $this->getConfigForTemplate($model);

        $data['tabbody'] = '.' . $config['tabbody'];
        $data['tabhead'] = \sprintf(
            '.%s>%s',
            $config['wrapperClass'],
            $config['tabhead']
        );


        $element->firstItem = true;
        $element->tabhead   = $config['tabhead'];
        $element->tabbody   = $config['tabbody'];
        $element->tabtitle  = $config['title'];
        $element->data      = $this->buildDataset($data);

        $content = $element->parentGenerate();

        return $content;
    }

    /**
     * Build the html dataset.
     *
     * @param array $data The data.
     *
     * @return string
     */
    private function buildDataset(array $data): string
    {
        $dataset = [];
        foreach ($data as $key => $value) {
            if (\is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            $dataset[] = \sprintf(
                'data-cbat-%s="%s"',
                \trim(\preg_replace('/([A-Z][a-z])/', '-\1', $key)),
                \htmlspecialchars($value)
            );
        }

        return \implode(' ', $dataset);
    }

    /**
     * Get configuration for the template.
     *
     * @param Model $model The model.
     *
     * @return array
     */
    private function getConfigForTemplate(Model $model): array
    {
        $tabConfig = $this->getTabConfigFromModel($model);
        $defaults  = [];
        foreach (\array_keys($tabConfig) as $configKey) {
            if (!$this->defaultSettings->has($configKey)) {
                continue;
            }

            $defaults[$configKey] = $this->defaultSettings->get($configKey);

            if (\is_bool($defaults[$configKey])) {
                $tabConfig[$configKey] = (bool) $tabConfig[$configKey];
            }
        }

        return \array_merge($defaults, $tabConfig);
    }
}
