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

namespace BlackForest\Contao\AccessibleTabs\EventListener\Table\Content;

use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * The add the notice for activate the javascript in the page layout.
 */
class ShowJsLibraryHintListener
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
     * The token storage.
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * The translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * The session.
     *
     * @var Session
     */
    private $session;

    /**
     * ShowJsLibraryHintListener constructor.
     *
     * @param Connection            $connection   The doctrine dbal connection.
     * @param RequestStack          $requestStack The request stack.
     * @param TokenStorageInterface $tokenStorage The token storage.
     * @param TranslatorInterface   $translator   The translator.
     * @param Session               $session      The session.
     */
    public function __construct(
        Connection $connection,
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage,
        TranslatorInterface $translator,
        Session $session
    ) {
        $this->connection   = $connection;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->translator   = $translator;
        $this->session      = $session;
    }

    /**
     * Generate the notice.
     *
     * @param DataContainer $container The data container.
     *
     * @return void
     */
    public function onGenerate(DataContainer $container): void
    {
        if (!$this->evaluateRequest()
            || !$this->userHasAccessRights()
            || !$this->fetchStartElement((int) $container->id)
        ) {
            return;
        }

        $this->session->getFlashBag()->add(
            'contao.BE.info',
            \sprintf(
                $this->translator->trans('tl_content.includeTemplates', [], 'contao_tl_content'),
                'moo_accessible_tabs',
                'j_accessible_tabs'
            )
        );
    }
    /**
     * Determine if the user has access rights.
     *
     * @return bool
     */
    private function userHasAccessRights(): bool
    {
        if (null === ($user = $this->tokenStorage->getToken())) {
            return false;
        }

        $isAdmin = \in_array(
            'ROLE_ADMIN',
            \array_map(
                function (Role $role) {
                    return $role->getRole();
                },
                $user->getRoles()
            ),
            true
        );
        if ($isAdmin) {
            return true;
        }

        $backendUser = $user->getUser();
        // Not show the notice if the non admin user has no rights of the layout and theme section.
        return !(!$backendUser->hasAccess('themes', 'modules') || !$backendUser->hasAccess('layout', 'themes'));
    }

    /**
     * Fetch the start element.
     *
     * @param int $identifier The element id.
     *
     * @return mixed
     */
    private function fetchStartElement(int $identifier)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select('c.id')
            ->from('tl_content', 'c')
            ->where($builder->expr()->eq('c.id', ':identifier'))
            ->andWhere($builder->expr()->eq('c.type', ':type'))
            ->setParameter(':identifier', $identifier)
            ->setParameter(':type', 'accessible_tabs_start');

        return $builder->execute()->fetch();
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
               && $request->query->has('act')
               && \in_array($request->query->get('act'), ['create', 'edit']);
    }
}
