<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 07/06/2018
 * Time: 10:53
 */

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;


class UserTest extends TestCase
{
    public function testSetEmailUser()
    {
        $user = new User;
        $user->setEmail('lisy@gmail.com');
        $this->assertSame('lisy@gmail.com', $user->getEmail());
    }

    public function testSetRoleUser()
    {
        $user = new User;
        $user->setRole('ROLE_USER');
        $this->assertSame('ROLE_USER', $user->getRole());
    }

    public function testSetTaskUser()
    {
        $task1 = new Task;
        $task1->setTitle('Tâche n°100');

        $task2 = new Task;
        $task2->setTitle('Tâche n°102');

        $user = new User;
        $user->addTask($task1);
        $user->addTask($task2);

        $this->assertCount(2, $user->getTasks());

        $user->removeTask($task2);
        $this->assertCount(1, $user->getTasks());
    }
}