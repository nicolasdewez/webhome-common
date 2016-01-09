<?php

namespace Ndewez\WebHome\CommonBundle\User;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use JMS\Serializer\Annotation\Type;
use Ndewez\WebHome\CommonBundle\Model\Application;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WebHomeUser.
 */
class WebHomeUser extends OAuthUser implements EquatableInterface
{
    const PREFIX_ROLE = 'ROLE_';

    /**
     * @Type("string")
     * @var string
     */
    protected $username;    // Just for type

    /**
     * @Type("string")
     * @var string
     */
    private $password;

    /**
     * @Type("string")
     * @var string
     */
    private $firstName;

    /**
     * @Type("string")
     * @var string
     */
    private $lastName;

    /**
     * @Type("string")
     * @var string
     */
    private $locale;

    /**
     * @Type("string")
     * @var string
     */
    private $accessToken;

    /**
     * @Type("string")
     * @var string
     */
    private $refreshToken;

    /**
     * @Type("array")
     * @var array
     */
    private $roles;

    /**
     * @Type("array")
     * @var array
     */
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
