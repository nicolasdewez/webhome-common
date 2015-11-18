<?php

namespace Ndewez\WebHome\CommonBundle\Menu;

use Ndewez\WebHome\AuthApiBundle\V0\Model\Authorization;

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
