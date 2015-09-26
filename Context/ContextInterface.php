<?php

namespace Ndewez\WebHome\CommonBundle\Context;

/**
 * Interface ContextInterface.
 */
interface ContextInterface
{
    public function getLocale();

    /**
     * @param string $locale
     */
    public function setLocale($locale);
}
