<?php

namespace Ndewez\WebHome\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     */
    public function userBarAction()
    {
        if (!$this->getUser()) {
            return new Response();
        }

        $serviceUserBar = $this->get('webhome.menu.user_bar');

        return $this->render('@NdewezWebHomeCommon/userBar.thml.twig', [
            'username' => $this->getUser()->getUsername(),
            'firstName' => $this->getUser()->getFirstName(),
            'lastName' => $this->getUser()->getLastName(),
            'applications' => $serviceUserBar->generateLinksApplications($this->getUser()->getApplications()),
            'urlShowAccount' => $serviceUserBar->generateLinkShowAccount(),
            'urlChangePassword' => $serviceUserBar->generateLinkChangePassword(),
        ]);
    }
}
