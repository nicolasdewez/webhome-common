<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use AppBundle\Service\Transformer\AuthorizationTransformer;
use Ndewez\WebHome\AuthApiBundle\V0\Service\WebHomeAuthClient;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class GetterAuthorizationsWebService.
 */
class GetterAuthorizationsWebService implements GetterAuthorizationsInterface
{
    /** @var TokenStorage*/
    private $tokenStorage;

    /** @var WebHomeAuthClient */
    private $authClient;

    /** @var AuthorizationTransformer */
    private $authorizationTransformer;

    /**
     * @param TokenStorage             $tokenStorage
     * @param WebHomeAuthClient        $authClient
     * @param AuthorizationTransformer $authorizationTransformer
     */
    public function __construct(TokenStorage $tokenStorage, WebHomeAuthClient $authClient, AuthorizationTransformer $authorizationTransformer)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authClient = $authClient;
        $this->authorizationTransformer = $authorizationTransformer;
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
        $user = $this->authClient->userInformations($token->getUsername());
        $collection = $user->getAuthorizations();
        foreach ($collection as $element) {
            $authorizations[] = $this->authorizationTransformer->entityToModel($element);
        }

        return $authorizations;
    }
}
