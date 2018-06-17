<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 15/06/2018
 * Time: 15:11
 */

namespace AppBundle\Model;


interface TaskCreatorInterface
{
    public function getUsername();

    public function canBeManagedBy($otherUser);

}