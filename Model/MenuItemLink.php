<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class MenuItemLink.
 */
class MenuItemLink extends MenuItem
{
    /**
     * {@inheritdoc}
     */
    public function isDivider()
    {
        return false;
    }
}
