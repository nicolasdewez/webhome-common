<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\Application as ApplicationModel;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class UserBar.
 */
class UserBar
{
    /** @var Router */
    private $router;

    /** @var string */
    private $codeApplication;

    /** @var string */
    private $webHomeAuthUrl;

    /**
     * @param Router $router
     * @param string $codeApplication
     * @param string $webHomeAuthUrl
     */
    public function __construct(Router $router, $codeApplication, $webHomeAuthUrl = null)
    {
        $this->router = $router;
        $this->codeApplication = $codeApplication;
        $this->webHomeAuthUrl = $webHomeAuthUrl;
    }

    /**
     * @param ApplicationModel[] $applications
     *
     * @return array
     */
    public function generateLinksApplications(array $applications)
    {
        $links = [];

        foreach ($applications as $application) {
            if ($this->codeApplication === $application->getCode()) {
                continue;
            }

            $links[] = [
                'href' => $application->getHref(),
                'title' => $application->getTitle(),
            ];
        }

        return $links;
    }

    /**
     * @return string
     */
    public function generateLinkShowAccount()
    {
        if (null === $this->webHomeAuthUrl) {
            return $this->router->generate('app_home_show_my_account');
        }

        return $this->webHomeAuthUrl.'/show-account';
    }

    /**
     * @return string
     */
    public function generateLinkChangePassword()
    {
        if (null === $this->webHomeAuthUrl) {
            return $this->router->generate('app_home_change_password');
        }

        return $this->webHomeAuthUrl.'/change-password';
    }
}
