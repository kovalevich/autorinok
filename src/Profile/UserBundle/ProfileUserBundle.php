<?php

namespace Profile\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProfileUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
