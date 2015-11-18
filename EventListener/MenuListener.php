<?php

namespace Ndewez\WebHome\CommonBundle\EventListener;

use Ndewez\WebHome\CommonBundle\Menu\BuilderMenu;
use Ndewez\WebHome\CommonBundle\Menu\BuilderMenuItemsInterface;
use Ndewez\WebHome\CommonBundle\Menu\GetterAuthorizationsInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class MenuListener.
 */
class MenuListener
{
    const KEY = 'app_menu';

    /** @var bool */
    private $useSession;

    /** @var Session */
    private $session;

    /** @var BuilderMenuItemsInterface */
    private $builderMenuItems;

    /** @var BuilderMenu */
    private $builderMenu;

    /** @var GetterAuthorizationsInterface */
    private $getter;

    /**
     * @param Session     $session
     * @param BuilderMenu $builderMenu
     */
    public function __construct(Session $session, BuilderMenu $builderMenu)
    {
        $this->session = $session;
        $this->builderMenu = $builderMenu;
    }

    /**
     * @param bool $useSession
     */
    public function setUseSession($useSession)
    {
        $this->useSession = $useSession;
    }

    /**
     * @param BuilderMenuItemsInterface $builderMenuItems
     */
    public function setBuilderMenuItems(BuilderMenuItemsInterface $builderMenuItems)
    {
        $this->builderMenuItems = $builderMenuItems;
    }

    /**
     * @param GetterAuthorizationsInterface $getter
     */
    public function setGetter(GetterAuthorizationsInterface $getter)
    {
        $this->getter = $getter;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        // Session is used for save authorizations and menu is already in session
        if ($this->useSession && $this->session->has(self::KEY)) {
            return;
        }

        $authorizations = $this->getter->get();
        $items = $this->builderMenuItems->build($authorizations);
        $menu = $this->builderMenu->build($items, $event->getRequest()->getRequestUri());

        $this->session->set(self::KEY, $menu);
    }
}
