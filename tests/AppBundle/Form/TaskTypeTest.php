<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 19/06/2018
 * Time: 21:10
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Form;

use AppBundle\Form\Type\TaskType;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    /**
     *
     */
    public function testSubmitValidDataTask()
    {
        $formData = [
            'title' => 'Title',
            'content' => 'Content',
        ];

        $form = $this->factory->create(TaskType::class);

        $task = new Task();
        $task->setTitle($formData['title']);
        $task->setContent($formData['content']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($task->getTitle(), $form->get('title')->getData());
        $this->assertEquals($task->getContent(), $form->get('content')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}