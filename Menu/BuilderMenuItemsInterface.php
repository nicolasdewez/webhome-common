<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\Authorization;
use Ndewez\WebHome\CommonBundle\Model\MenuItem;

/**
 * Interface BuilderMenuItemsInterface.
 */
interface BuilderMenuItemsInterface
{
    /**
     * @param Authorization[] $authorizations
     *
     * @return MenuItem[]
     */
    public function build(array $authorizations);
}
