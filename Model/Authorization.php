<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class Authorization.
 */
class Authorization
{
    /**
     * @var string
     */
    private $codeAction;

    /**
     * @var bool
     */
    private $granted;

    /**
     * @return string
     */
    public function getCodeAction()
    {
        return $this->codeAction;
    }

    /**
     * @param string $codeAction
     *
     * @return Authorization
     */
    public function setCodeAction($codeAction)
    {
        $this->codeAction = $codeAction;

        return $this;
    }

    /**
     * @return bool
     */
    public function isGranted()
    {
        return $this->granted;
    }

    /**
     * @param bool $granted
     *
     * @return Authorization
     */
    public function setGranted($granted)
    {
        $this->granted = $granted;

        return $this;
    }
}
