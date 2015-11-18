<?php

namespace Ndewez\WebHome\CommonBundle\Logout;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

/**
 * Class RedirectionHandler.
 */
class RedirectionHandler extends ContainerAware implements LogoutSuccessHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function onLogoutSuccess(Request $request)
    {
        try {
            return new RedirectResponse(sprintf(
                '%s?redirect=%s',
                $this->container->getParameter('webhome_auth_url'),
                urlencode($this->container->get('router')->generate(
                    $this->getHomepageRouteName(),
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ))
            ));
        } catch (ResourceNotFoundException $exception) {
            // no homepage? simple redirection to sheriff logout
            return new RedirectResponse($this->container->getParameter('webhome_auth.logout_url'));
        }
    }

    /**
     * @throws ResourceNotFoundException if the route is not found
     *
     * @return string the route name
     */
    private function getHomepageRouteName()
    {
        $routeInfo = $this->container->get('router')->match('/');

        return $routeInfo['_route'];
    }
}
