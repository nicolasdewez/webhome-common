<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\MenuItem;
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
        $uri = $this->router->generate($menuItem->getRoute(), $menuItem->getParametersRoute());
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
