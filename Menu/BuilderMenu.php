<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\MenuItem;
use Ndewez\WebHome\CommonBundle\Model\MenuItemDivider;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class BuilderMenu.
 */
class BuilderMenu
{
    /** @var Router */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param MenuItem[] $items
     * @param string     $currentUri
     *
     * @return MenuItem[]
     */
    public function build(array $items, $currentUri)
    {
        foreach ($items as $item) {
            if ($item->isDivider()) {
                continue;
            }

            $this->buildItem($item, $currentUri);
        }

        return $items;
    }

    /**
     * @param MenuItem $menuItem
     * @param string   $currentUri
     */
    private function buildItem(MenuItem $menuItem, $currentUri)
    {
        if ($menuItem instanceof MenuItemDivider) {
            return;
        }

        if ($menuItem->hasItem()) {
            foreach ($menuItem->getItems() as $item) {
                $this->buildItem($item, $currentUri);

                if ($item->isActive()) {
                    $menuItem->setActive(true);
                }
            }

            return;
        }

        $uri = $menuItem->getRoute() ? $this->router->generate($menuItem->getRoute(), $menuItem->getParametersRoute()) : '';
        $uriHome = $this->router->generate('app_home');

        $active = false;
        if ($uri === $currentUri || ($uri != $uriHome && preg_match('#^'.$uri.'#', $currentUri))) {
            $active = true;
        }

        $menuItem
            ->setActive($active)
            ->setHref($uri);
    }
}
