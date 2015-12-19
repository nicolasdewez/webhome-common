<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class MenuItem.
 */
abstract class MenuItem
{
    /** @var string */
    private $title;

    /** @var string */
    private $route;

    /** @var array */
    private $parametersRoute;

    /** @var string */
    private $href;

    /** @var bool */
    private $active;

    /** @var MenuItem[] */
    private $items;

    public function __construct()
    {
        $this->parametersRoute = [];
        $this->items = [];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return MenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return MenuItem
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     *
     * @return MenuItem
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return array
     */
    public function getParametersRoute()
    {
        return $this->parametersRoute;
    }

    /**
     * @param array $parametersRoute
     *
     * @return MenuItem
     */
    public function setParametersRoute($parametersRoute)
    {
        $this->parametersRoute = $parametersRoute;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return MenuItem
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return MenuItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param MenuItem[] $items
     *
     * @return MenuItem
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param MenuItem $item
     *
     * @return $this
     */
    public function addItem(MenuItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasItem()
    {
        return count($this->items) > 0;
    }

    /**
     * @return bool
     */
    abstract public function isDivider();
}
