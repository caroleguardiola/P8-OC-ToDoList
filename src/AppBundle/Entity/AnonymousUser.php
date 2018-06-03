<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 03/06/2018
 * Time: 21:31
 */

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class AnonymousUser implements UserInterface
{
    public function getUsername()
    {
        return 'Anonymous';
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return 'Anonymous';
    }

    public function getEmail()
    {
        return 'Anonymous';
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
}
