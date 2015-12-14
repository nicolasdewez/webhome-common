<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class Application.
 */
class Application
{
    /** @var string */
    private $href;

    /** @var string */
    private $code;

    /** @var string */
    private $title;

    /**
     * @param string $code
     * @param string $title
     */
    public function __construct($code, $title, $href)
    {
        $this->code = $code;
        $this->title = $title;
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Application
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
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
     * @return Application
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
     * @return Application
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }
}
