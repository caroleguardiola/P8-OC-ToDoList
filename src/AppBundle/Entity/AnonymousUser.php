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
    public function getId()
    {
    }

    public function getUsername()
    {
        return 'Anonymous';
    }

    public function getSalt()
    {
    }

    public function getPassword()
    {
    }

    public function getEmail()
    {
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}
