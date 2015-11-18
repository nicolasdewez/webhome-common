<?php

namespace Ndewez\WebHome\CommonBundle\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WebHomeUser.
 */
class WebHomeUser extends OAuthUser implements EquatableInterface
{
    private $password;
    private $fullName;
    private $accessToken;

    /**
     * @param string $username
     * @param string $password
     * @param string $fullName
     * @param string $accessToken
     */
    public function __construct($username, $password, $fullName, $accessToken)
    {
        parent::__construct($username);

        $this->password = $password;
        $this->fullName = $fullName;
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $roles = array('ROLE_USER');

        return $roles;
    }

    /**
     * @inheritdoc
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof OAuthUser) {
            return false;
        }

        return $user->equals($this);
    }
}
