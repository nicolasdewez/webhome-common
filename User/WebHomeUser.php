<?php

namespace Ndewez\WebHome\CommonBundle\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Ndewez\WebHome\CommonBundle\Model\Application;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WebHomeUser.
 */
class WebHomeUser extends OAuthUser implements EquatableInterface
{
    const PREFIX_ROLE = 'ROLE_';

    /** @var string */
    private $password;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $locale;

    /** @var string */
    private $accessToken;

    /** @var string */
    private $refreshToken;

    /** @var array */
    private $roles;

    /** @var array */
    private $applications;

    /**
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $locale
     * @param string $accessToken
     * @param string $refreshToken
     */
    public function __construct($username, $password, $firstName, $lastName, $locale, $accessToken, $refreshToken)
    {
        parent::__construct($username);

        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->locale = $locale;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->roles = [];
        $this->applications = [];
    }

    /**
     * @param array $roles
     */
    public function initRolesAndApplications(array $roles)
    {
        foreach ($roles as $role) {
            // Role
            $this->roles[] = self::PREFIX_ROLE.$role['code'];

            // Application
            $application = new Application(
                $role['application']['code'],
                $role['application']['title'],
                $role['application']['href']
            );
            if (!in_array($application, $this->applications)) {
                $this->applications[] = $application;
            }
        }
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getApplications()
    {
        return $this->applications;
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
