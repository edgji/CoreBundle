<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Controller\Widget;

use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Manager\WorkspaceTagManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;

class MyWorkspacesWidgetController extends Controller
{
    private $securityContext;
    private $utils;
    private $workspaceManager;
    private $workspaceTagManager;

    /**
     * @DI\InjectParams({
     *     "securityContext"        = @DI\Inject("security.context"),
     *     "utils"                  = @DI\Inject("claroline.security.utilities"),
     *     "workspaceManager"       = @DI\Inject("claroline.manager.workspace_manager"),
     *     "workspaceTagManager"    = @DI\Inject("claroline.manager.workspace_tag_manager")
     * })
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        Utilities $utils,
        WorkspaceManager $workspaceManager,
        WorkspaceTagManager $workspaceTagManager
    )
    {
        $this->securityContext = $securityContext;
        $this->utils = $utils;
        $this->workspaceManager = $workspaceManager;
        $this->workspaceTagManager = $workspaceTagManager;
    }

    /**
     * @EXT\Route(
     *     "/workspaces/widget/{mode}",
     *     name="claro_display_workspaces_widget",
     *     options={"expose"=true}
     * )
     *
     * @EXT\Template("ClarolineCoreBundle:Widget:displayMyWorkspacesWidget.html.twig")
     * @EXT\ParamConverter("user", options={"authenticatedUser" = true})
     *
     * Renders the workspaces list widget
     *
     * @return Response
     */
    public function displayMyWorkspacesWidgetAction($mode, User $user)
    {
        $workspaces = array();
        $retrieveWorkspaces = true;

        if ($mode === 0) {
            $workspaces = $this->workspaceManager
                ->getFavouriteWorkspacesByUser($user);

            if (count($workspaces) > 0) {
                $mode = 1;
                $retrieveWorkspaces = false;
            }
        }

        switch ($mode) {
            case 1:

                if ($retrieveWorkspaces) {
                    $workspaces = $this->workspaceManager
                        ->getFavouriteWorkspacesByUser($user);
                }
                break;
            default:
                $token = $this->securityContext->getToken();
                $roles = $this->utils->getRoles($token);
                $datas = $this->workspaceTagManager
                    ->getDatasForWorkspaceListByUser($user, $roles);
                $workspaces = $datas['workspaces'];
        }

        return array('workspaces' => $workspaces, 'mode' => $mode);
    }
}
