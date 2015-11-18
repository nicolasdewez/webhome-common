<?php

namespace Ndewez\WebHome\CommonBundle\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WebHomeUserProvider.
 */
class WebHomeUserProvider extends OAuthUserProvider
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return new WebHomeUser($response->getNickname(), null, $response->getRealName(), $response->getAccessToken());
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new \Exception(sprintf('Unsupported user class "%s"', get_class($user)));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Ndewez\\WebHome\\CommonBundle\\User\\WebHomeUser';
    }
}
