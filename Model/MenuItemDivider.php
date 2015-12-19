<?php

namespace Ndewez\WebHome\CommonBundle\Model;

/**
 * Class MenuItemDivider.
 */
class MenuItemDivider extends MenuItem
{
    /**
     * {@inheritdoc}
     */
    public function isDivider()
    {
        return true;
    }
}
