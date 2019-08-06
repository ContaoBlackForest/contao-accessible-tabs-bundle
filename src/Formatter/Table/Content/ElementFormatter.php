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

namespace BlackForest\Contao\AccessibleTabs\Formatter\Table\Content;

use Contao\DataContainer;
use Contao\Model;
use Doctrine\DBAL\Connection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

/**
 * The element formatter.
 */
class ElementFormatter
{
    /**
     * The doctrine dbal connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * The request stack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * The twig environment.
     *
     * @var Environment
     */
    private $twig;

    /**
     * The filesystem.
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * The project directory.
     *
     * @var string
     */
    private $projectDirectory;

    /**
     * Rotating color value.
     *
     * @var string
     */
    private $rotatingColor;

    /**
     * Initial saturation.
     *
     * @var float
     */
    private $saturation;

    /**
     * Color Value.
     *
     * @var float
     */
    private $value;

    /**
     * The elements.
     *
     * @var array
     */
    private $elements;

    /**
     * The sorted elements.
     *
     * @var array
     */
    private $sorted;

    /**
     * The formatted elements.
     *
     * @var array
     */
    private $formatted;

    /**
     * The colors for each tab main grouping.
     *
     * @var array
     */
    private $mainColors;

    /**
     * The svg data cache.
     *
     * @var array
     */
    private $svg;

    /**
     * The stylesheet cache.
     *
     * @var array
     */
    private $stylesheet;

    /**
     * ElementFormatter constructor.
     *
     * @param Connection   $connection       The doctrine dbal connection.
     * @param RequestStack $requestStack     The request stack.
     * @param Environment  $twig             The twig environment.
     * @param Filesystem   $filesystem       The filesystem.
     * @param string       $projectDirectory The project directory.
     * @param float        $rotatingColor    Rotating color value.
     * @param float        $saturation       Initial saturation.
     * @param float        $value            Color Value.
     */
    public function __construct(
        Connection $connection,
        RequestStack $requestStack,
        Environment $twig,
        Filesystem $filesystem,
        string $projectDirectory,
        float $rotatingColor = .5,
        float $saturation = 0.7,
        float $value = .7
    ) {
        $this->connection       = $connection;
        $this->requestStack     = $requestStack;
        $this->twig             = $twig;
        $this->filesystem       = $filesystem;
        $this->projectDirectory = $projectDirectory;
        $this->rotatingColor    = $rotatingColor;
        $this->saturation       = $saturation;
        $this->value            = $value;
    }

    /**
     * Initialize the element formatter.
     *
     * @param DataContainer $container The data container.
     *
     * @return void
     */
    public function onInitialize(DataContainer $container): void
    {
        if (!($this->evaluateRequest())
            || !($elements = $this->fetchAllStartAndEndElement((int) $container->id, $container->parentTable))
        ) {
            return;
        }

        $this->addSortedElements($elements);
        $this->addSubElements();
        $this->generateMainColors();
    }

    /**
     * Format the content element.
     *
     * @param Model $model The model.
     *
     * @return string|null
     */
    public function format(Model $model): ?string
    {
        if (!($element = $this->elements[$model->id])
            || !($sortedElements = $this->sorted[$element->sortedIndex])
        ) {
            return null;
        }

        $stylesheetName = \md5(\implode(',', \array_keys($sortedElements)));
        if (($formattedElement = $this->formatted[$element->id])) {
            $GLOBALS['TL_CSS'][$stylesheetName] = $this->stylesheet[$stylesheetName];

            return $formattedElement;
        }

        $this->formatGroupOfElements($sortedElements);
        $this->generateStylesheet($sortedElements, $stylesheetName);

        $GLOBALS['TL_CSS'][$stylesheetName] = $this->stylesheet[$stylesheetName];

        return $this->formatted[$element->id];
    }

    /**
     * Format a group of elements.
     *
     * @param array $elements The elements.
     *
     * @return void
     */
    private function formatGroupOfElements(array $elements): void
    {
        $titleList = $this->getTitleList($elements);
        foreach ($elements as $element) {
            $currentElement = $this->elements[$element->id];
            $this->addNestedInformation($currentElement);
            $currentTitleList = (array) $titleList[$currentElement->sortedIndex];
            $this->formatStartElement($currentElement, $currentTitleList);
            $this->formatSeparatorElement($currentElement, $currentTitleList);
            $this->formatStopElement($currentElement, $currentTitleList);
            $this->formatInnerElement($currentElement, $currentTitleList);
            $this->drawBorderImage($currentElement);
        }
    }

    /**
     * Generate the stylesheet.
     *
     * @param array  $elements The elements.
     * @param string $name     The stylesheet name.
     *
     * @return void
     */
    private function generateStylesheet(array $elements, string $name): void
    {
        $items = [];
        foreach ($elements as $element) {
            $currentElement = $this->elements[$element->id];
            $svgKey         = \md5(\implode(',', $currentElement->nested));
            $svg            = $this->svg[$svgKey];

            $items[] = [
                'element' => $currentElement,
                'svg'     => $svg
            ];
        }

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_element.css.twig',
            [
                'items' => $items
            ]
        );

        $path = 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $name . '.css';
        $this->filesystem->dumpFile($this->projectDirectory . DIRECTORY_SEPARATOR . $path, $content);

        $this->stylesheet[$name] = $path;
    }

    /**
     * Add the nested information to element.
     *
     * @param \stdClass $element The element.
     *
     * @return void
     */
    private function addNestedInformation(\stdClass $element): void
    {
        $nested = [];
        foreach ($this->sorted as $index => $sorted) {
            if (!\array_key_exists($element->sorting, $sorted)) {
                continue;
            }

            $nested[] = $index;
        }

        $element->nested = $nested;
    }

    /**
     * Format the start element.
     *
     * @param \stdClass $element   The element.
     * @param array     $titleList The title list.
     *
     * @return void
     */
    private function formatStartElement(\stdClass $element, array $titleList): void
    {
        if ('accessible_tabs_start' !== $element->type) {
            return;
        }

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_start.html.twig',
            [
                'id'           => $element->id,
                'type'         => $element->type,
                'title'        => $element->accessible_tabs_title,
                'titles'       => $titleList,
                'color'        => $this->mainColors[$element->sortedIndex],
                'wrapperClass' => '"wrapper_start"',
                'index'        => $element->sortedIndex,
                'nested'       => $element->nested
            ]
        );

        $this->formatted[$element->id] = $content;
    }

    /**
     * Format the separator element.
     *
     * @param \stdClass $element   The element.
     * @param array     $titleList The title list.
     *
     * @return void
     */
    private function formatSeparatorElement(\stdClass $element, array $titleList): void
    {
        if ('accessible_tabs_separator' !== $element->type) {
            return;
        }

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_separator.html.twig',
            [
                'id'           => $element->id,
                'type'         => $element->type,
                'title'        => $element->accessible_tabs_title,
                'titles'       => $titleList,
                'color'        => $this->mainColors[$element->sortedIndex],
                'wrapperClass' => '"wrapper_separator", "indent"',
                'index'        => $element->sortedIndex,
                'nested'       => $element->nested
            ]
        );

        $this->formatted[$element->id] = $content;
    }

    /**
     * Format the stop element.
     *
     * @param \stdClass $element   The element.
     * @param array     $titleList The title list.
     *
     * @return void
     */
    private function formatStopElement(\stdClass $element, array $titleList): void
    {
        if ('accessible_tabs_stop' !== $element->type) {
            return;
        }

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_stop.html.twig',
            [
                'id'           => $element->id,
                'type'         => $element->type,
                'title'        => $element->accessible_tabs_title,
                'titles'       => $titleList,
                'color'        => $this->mainColors[$element->sortedIndex],
                'wrapperClass' => '"wrapper_stop"',
                'index'        => $element->sortedIndex,
                'nested'       => $element->nested
            ]
        );

        $this->formatted[$element->id] = $content;
    }

    /**
     * Format the inner element.
     *
     * @param \stdClass $element   The element.
     * @param array     $titleList The title list.
     *
     * @return void
     */
    private function formatInnerElement(\stdClass $element, array $titleList): void
    {
        if (\in_array($element->type, ['accessible_tabs_start', 'accessible_tabs_separator', 'accessible_tabs_stop'])) {
            return;
        }

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_content.html.twig',
            [
                'id'           => $element->id,
                'type'         => $element->type,
                'title'        => $element->accessible_tabs_title,
                'titles'       => $titleList,
                'color'        => $this->mainColors[$element->sortedIndex],
                'wrapperClass' => '"indent"',
                'index'        => $element->sortedIndex,
                'nested'       => $element->nested
            ]
        );

        $this->formatted[$element->id] = $content;
    }

    /**
     * Draw the border image.
     *
     * @param \stdClass $element The element.
     *
     * @return void
     */
    private function drawBorderImage(\stdClass $element): void
    {
        $key = \md5(\implode(',', $element->nested));
        if ($this->svg[$key]) {
            return;
        }

        $svgWidth    = 10;
        $svgHeight   = 30;
        $thickness   = 4;
        $gutterWidth = 10;

        $svgWidth += (2 * $gutterWidth * (\count($element->nested) ?? 1));

        $svg = [
            'width'  => $svgWidth,
            'height' => $svgHeight,
            'levels' => []
        ];

        $level = 1;
        foreach ($element->nested as $index) {
            $svg['levels'][$level] = [
                'color'    => \sprintf('rgb(%s)', $this->mainColors[$index]),
                'isOpen'   => $element->sortedIndex === $index,
                'isClosed' => $element->sortedIndex === $index
            ];

            $level++;
        }

        $config = [
            'svgWidth'    => $svgWidth,
            'svgHeight'   => $svgHeight,
            'thickness'   => $thickness,
            'gutterWidth' => $gutterWidth,
        ];

        $content = $this->twig->render(
            '@BlackForestContaoAccessibleTabs/Backend/be_accessible_tabs_element.svg.twig',
            [
                'svg'    => $svg,
                'config' => $config
            ]
        );

        $this->svg[$key] = [
            'content'  => $content,
            'svg'      => $svg,
            'svgImage' => 'data:image/svg+xml;base64,' . \base64_encode($content),
            'config'   => $config
        ];
    }

    /**
     * Get the title list.
     *
     * @param array $elements The elements.
     *
     * @return array
     */
    private function getTitleList(array $elements): array
    {
        $titleList = [];
        foreach ($elements as $element) {
            $currentElement = $this->elements[$element->id];
            if (!\in_array($currentElement->type, ['accessible_tabs_start', 'accessible_tabs_separator'])) {
                continue;
            }

            $titleList[$currentElement->sortedIndex][$currentElement->id] = $currentElement->accessible_tabs_title;
        }

        return $titleList;
    }

    /**
     * Add the sorted elements.
     *
     * @param array $elements The elements.
     *
     * @return void
     */
    private function addSortedElements(array $elements): void
    {
        $index         = 0;
        $startElements = [];
        foreach ($elements as $element) {
            $this->elements[$element->id] = $element;

            if ('accessible_tabs_start' === $element->type) {
                $index++;
                $startElements[$index]                   = $element;
                $this->sorted[$index][$element->sorting] = $element;

                continue;
            }

            if (('accessible_tabs_stop' === $element->type)
                && 1 === \count($this->sorted[$index])
            ) {
                $this->sorted[$index][$element->sorting] = $element;

                unset($startElements[$index]);

                continue;
            }

            $backwardIndex = \array_slice(\array_keys($startElements), -1, 1)[0];

            $this->sorted[$backwardIndex][$element->sorting] = $element;

            unset($startElements[$backwardIndex]);
        }
    }

    /**
     * Add the sub elements.
     *
     * @return void
     */
    private function addSubElements(): void
    {
        foreach ($this->sorted as $index => $elements) {
            if (1 === \count($elements)) {
                $singleElement = \array_pop($elements);

                if ($this->elements[$singleElement->id]) {
                    $singleElement = $this->elements[$singleElement->id];
                }

                $singleElement->sortedIndex = $index;

                continue;
            }

            if (2 !== \count($elements)) {
                continue;
            }

            $endElement   = \array_pop($elements);
            $startElement = \array_pop($elements);

            if ($this->elements[$startElement->id]) {
                $startElement = $this->elements[$startElement->id];
            }
            if ($this->elements[$endElement->id]) {
                $endElement = $this->elements[$endElement->id];
            }

            $startElement->sortedIndex = $index;
            $endElement->sortedIndex   = $index;

            $subElements = $this->fetchAllInSortingRange(
                (int) $startElement->sorting,
                (int) $endElement->sorting,
                (int) $startElement->pid,
                $startElement->ptable
            );

            $sorted                            = [];
            $sorted[$startElement->sorting]    = $startElement;
            $this->elements[$startElement->id] = $startElement;
            if (!$subElements) {
                $sorted[$endElement->sorting] = $endElement;

                $this->sorted[$index] = $sorted;

                continue;
            }

            $this->addSortedSubElements($subElements, $index, $sorted);

            $sorted[$endElement->sorting] = $endElement;

            $this->sorted[$index] = $sorted;
        }
    }

    /**
     * Add the sorted sub elements.
     *
     * @param array $subElements The sub elements.
     * @param int   $index       The index.
     * @param array $sorted      The sorted elements.
     *
     * @return void
     */
    private function addSortedSubElements(array $subElements, int $index, array &$sorted): void
    {
        foreach ($subElements as $subElement) {
            $sorted[$subElement->sorting]    = $subElement;
            $subElement->sortedIndex         = $index;
            $this->elements[$subElement->id] = $subElement;
        }
    }

    /**
     * Generate the main colors.
     *
     * @return void
     */
    private function generateMainColors(): void
    {
        foreach (\array_keys($this->sorted) as $index) {
            $this->mainColors[$index] = $this->rotateColor();
        }
    }

    /**
     * Fetch all elements in the sorting range.
     *
     * @param int    $start       The start index.
     * @param int    $end         The end index.
     * @param int    $pid         The parent id.
     * @param string $parentTable The parent table.
     *
     * @return array|null
     */
    private function fetchAllInSortingRange(int $start, int $end, int $pid, string $parentTable): ?array
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id',
                'c.pid',
                'c.ptable',
                'c.type',
                'c.sorting',
                'c.accessible_tabs_title',
                'c.accessible_tabs_anchor'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->setParameter(':identifier', $pid)
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere($builder->expr()->gt('c.sorting', ':start'))
            ->andWhere($builder->expr()->lt('c.sorting', ':end'))
            ->setParameter(':ptable', $parentTable)
            ->setParameter(':start', $start)
            ->setParameter(':end', $end)
            ->orderBy('c.sorting');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Fetch all start and end element.
     *
     * @param int    $identifier  The parent element id.
     * @param string $parentTable The parent table.
     *
     * @return array|null
     */
    private function fetchAllStartAndEndElement(int $identifier, string $parentTable): ?array
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select(
                'c.id',
                'c.pid',
                'c.ptable',
                'c.type',
                'c.sorting',
                'c.accessible_tabs_title',
                'c.accessible_tabs_anchor'
            )
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.pid', ':identifier'))
            ->andWhere($builder->expr()->eq('c.ptable', ':ptable'))
            ->andWhere(
                $builder->expr()->orX(
                    $builder->expr()->eq('c.type', ':startType'),
                    $builder->expr()->eq('c.type', ':endType')
                )
            )
            ->setParameter(':identifier', $identifier)
            ->setParameter(':ptable', $parentTable)
            ->setParameter(':startType', 'accessible_tabs_start')
            ->setParameter(':endType', 'accessible_tabs_stop')
            ->orderBy('c.sorting');

        $statement = $builder->execute();
        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Evaluate the request.
     *
     * @return bool
     */
    private function evaluateRequest(): bool
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request
               && !($request->query->has('act')
                    && \in_array(
                        $request->query->get('act'),
                        [
                            'create',
                            'edit',
                            'copy',
                            'cut',
                            'delete',
                            'toggle',
                            'show',
                            'editAll',
                            'overrideAll',
                            'deleteAll'
                        ]
                    )
            )
               // Not allowed by toggle.
               && !$request->query->has('tid')
               && !$request->query->has('state');
    }

    /**
     * Rotate the color value.
     *
     * @return string
     */
    private function rotateColor(): string
    {
        $color = $this->convertHexToRgb($this->convertHSVtoRGB($this->rotatingColor, $this->saturation, $this->value));

        $this->rotatingColor += .3;

        if ($this->rotatingColor > 1) {
            --$this->rotatingColor;
        }

        return $color;
    }

    /**
     * Convert hsv value to rgb value.
     *
     * @param float $hue        Hue.
     * @param float $saturation Saturation.
     * @param float $value      Color value.
     *
     * @return string
     * @see    http://stackoverflow.com/a/3597447
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private function convertHSVtoRGB(float $hue, float $saturation, float $value): string
    {
        // First
        $hue *= 6;

        // Second
        $i = \floor($hue);
        $f = ($hue - $i);

        // Third
        $m = ($value * (1 - $saturation));
        $n = ($value * (1 - $saturation * $f));
        $k = ($value * (1 - $saturation * (1 - $f)));

        // Forth
        switch ($i) {
            case 0:
                [$red, $green, $blue] = [$value, $k, $m];
                break;
            case 1:
                [$red, $green, $blue] = [$n, $value, $m];
                break;
            case 2:
                [$red, $green, $blue] = [$m, $value, $k];
                break;
            case 3:
                [$red, $green, $blue] = [$m, $n, $value];
                break;
            case 4:
                [$red, $green, $blue] = [$k, $m, $value];
                break;
            case 5:
            case 6:
                // for when $H=1 is given
            default:
                [$red, $green, $blue] = [$value, $m, $n];
                break;
        }

        return \sprintf('#%02x%02x%02x', ($red * 255), ($green * 255), ($blue * 255));
    }

    /**
     * Convert the hex color to rgb.
     *
     * @param string $hex The hex color.
     *
     * @return string
     */
    private function convertHexToRgb(string $hex): string
    {
        $hex = \str_replace('#', '', $hex);

        if (3 === \strlen($hex)) {
            $r = \hexdec(\substr($hex, 0, 1) . \substr($hex, 0, 1));
            $g = \hexdec(\substr($hex, 1, 1) . \substr($hex, 1, 1));
            $b = \hexdec(\substr($hex, 2, 1) . \substr($hex, 2, 1));
        } else {
            $r = \hexdec(\substr($hex, 0, 2));
            $g = \hexdec(\substr($hex, 2, 2));
            $b = \hexdec(\substr($hex, 4, 2));
        }

        $rgb = [$r, $g, $b];

        return implode(',', $rgb);
    }
}
