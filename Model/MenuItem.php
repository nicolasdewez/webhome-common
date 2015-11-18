<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class MenuItem.
 */
class MenuItem
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

    public function __construct()
    {
        $this->parametersRoute = [];
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
}
