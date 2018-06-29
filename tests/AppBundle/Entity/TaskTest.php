<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 07/06/2018
 * Time: 10:35
 */

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;


class TaskTest extends TestCase
{
    /**
     *
     */
    public function testSetCreatedAtTask()
    {
        $task = new Task;
        $task->setCreatedAt('2018-05-14 17:30:00');
        $this->assertSame('2018-05-14 17:30:00', $task->getCreatedAt());
    }

    /**
     *
     */
    public function testSetTitleTask()
    {
        $task = new Task;
        $task->setTitle('Tâche n°1');
        $this->assertSame('Tâche n°1', $task->getTitle());
    }

    /**
     *
     */
    public function testSetContentTask()
    {
        $task = new Task;
        $task->setContent('Tâche n°1 contenu');
        $this->assertSame('Tâche n°1 contenu', $task->getContent());
    }

    /**
     *
     */
    public function testToggleTask()
    {
        $task = new Task;
        $task->toggle(true);
        $this->assertSame(true, $task->isDone());
    }

    /**
     *
     */
    public function testSetUserTask()
    {
        $user = new User;
        $user->setUsername('Lisy');

        $task = new Task;
        $task->setUser($user);

        $this->assertSame('Lisy', $task->getUser()->getUsername());
    }
}