<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\CommonBundle\Model\Authorization;

/**
 * Interface GetterAuthorizationsInterface.
 */
interface GetterAuthorizationsInterface
{
    /**
     * @return Authorization[]
     */
    public function get();
}
