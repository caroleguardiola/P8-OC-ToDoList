<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 19/06/2018
 * Time: 21:10
 */

namespace Tests\AppBundle\Form;

use AppBundle\Form\TaskType;
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