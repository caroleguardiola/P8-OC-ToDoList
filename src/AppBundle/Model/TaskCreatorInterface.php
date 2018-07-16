<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 15/06/2018
 * Time: 15:11
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

interface TaskCreatorInterface
{
    /**
     * @return mixed
     */
    public function getUsername();

    /**
     * @param $otherUser
     * @return mixed
     */
    public function canBeManagedBy($otherUser);
}
