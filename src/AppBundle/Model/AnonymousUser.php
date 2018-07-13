<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 03/06/2018
 * Time: 21:31
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Model;

class AnonymousUser implements TaskCreatorInterface
{
    /**
     * @return string
     */
    public function getUsername()
    {
        return 'Anonymous';
    }

    /**
     * @param $otherUser
     * @return bool
     */
    public function canBeManagedBy($otherUser)
    {
        if(in_array('ROLE_ADMIN',$otherUser->getRoles())) {
            return true;
        }
        return false;
    }
}
