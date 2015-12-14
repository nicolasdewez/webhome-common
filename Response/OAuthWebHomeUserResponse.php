<?php

namespace Ndewez\WebHome\CommonBundle\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;

/**
 * Class OAuthWebHomeUserResponse.
 */
class OAuthWebHomeUserResponse extends PathUserResponse
{
    public function __construct()
    {
        $this->paths['roles'] = null;
        $this->paths['locale'] = null;
    }

    /**
     * @return null|array
     */
    public function getRoles()
    {
        return $this->getValueForPath('roles');
    }

    /**
     * @return null|string
     */
    public function getLocale()
    {
        return $this->getValueForPath('locale');
    }
}
