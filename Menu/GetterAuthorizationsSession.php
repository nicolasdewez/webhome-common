<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\Authorization;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class GetterAuthorizationsSession.
 */
class GetterAuthorizationsSession implements GetterAuthorizationsInterface
{
    /** @var TokenStorage*/
    private $tokenStorage;

   /**
     * @param TokenStorage             $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $token = $this->tokenStorage->getToken();
        if (null === $token || !is_object($token->getUser())) {
            return [];
        }

        $authorizations = [];
        foreach ($token->getUser()->getRoles() as $authorization) {
            $auth = new Authorization();
            $auth->setCodeAction($authorization);
            $auth->setGranted(true);

            $authorizations[] = $auth;
        }

        return $authorizations;
    }
}
