<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 03/06/2018
 * Time: 21:31
 */

namespace AppBundle\Model;

class AnonymousUser implements TaskCreatorInterface
{
    public function getUsername()
    {
        return 'Anonymous';
    }

    public function canBeManagedBy($otherUser)
    {
        if(in_array('ROLE_ADMIN',$otherUser->getRoles())) {
            return true;
        }
        return false;
    }
}
