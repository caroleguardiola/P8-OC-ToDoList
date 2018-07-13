<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 16:15
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\AppWebTestCase;
use AppBundle\Entity\Task;

class TaskControllerTest extends AppWebTestCase
{
    /**
     *
     */
    public function testListTasksAsAnonymousAction()
    {
        $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testListTasksAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    /**
     *
     */
    public function testListTasksAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    /**
     *
     */
    public function testCreateButtonTaskAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Titre")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    /**
     *
     */
    public function testCreateButtonTaskAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->client->click($link);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Titre")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    /**
     *
     */
    public function testCreatePageTaskAsAnonymousAction()
    {
        $this->client->request('GET', '/tasks/create');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testCreatePageTaskAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Titre")')->count());
    }

    /**
     *
     */
    public function testCreatePageTaskAsAdminAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Titre")')->count());
    }

    /**
     *
     */
    public function testCreateTaskAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche de test à créer';
        $form['task[content]'] = 'Contenu de la tâche de test à créer';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a été bien été ajoutée.")')->count());

        $userTaskCreated = $this->getEntityManager()->getRepository(Task::class)->findOneBy(['title' => 'Tâche de test à créer']);
        $this->assertSame('user', $userTaskCreated->getUser()->getUsername());
    }

    /**
     *
     */
    public function testCreateTaskAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche de test à créer';
        $form['task[content]'] = 'Contenu de la tâche de test à créer';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a été bien été ajoutée.")')->count());

    }

    /**
     *
     */
    public function testCreateTaskEmptyAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = '';
        $form['task[content]'] = '';

        $crawler = $this->client->submit($form);
        $this->assertSame(1, $crawler->filter('html:contains("Vous devez saisir un titre.")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Vous devez saisir du contenu.")')->count());

    }

    /**
     *
     */
    public function testCreateTaskWithoutTitleAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = '';
        $form['task[content]'] = 'Contenu';

        $crawler = $this->client->submit($form);
        $this->assertSame(1, $crawler->filter('html:contains("Vous devez saisir un titre.")')->count());
        $this->assertSame(0, $crawler->filter('html:contains("Vous devez saisir du contenu.")')->count());
    }

    /**
     *
     */
    public function testCreateTaskWithoutContentAsUserAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche';
        $form['task[content]'] = '';

        $crawler = $this->client->submit($form);
        $this->assertSame(0, $crawler->filter('html:contains("Vous devez saisir un titre.")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Vous devez saisir du contenu.")')->count());
    }

    /**
     *
     */
    public function testConsultListButtonTaskAction()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Consulter la liste des tâches')->link();
        $crawler = $this->client->click($link);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    /**
     *
     */
    public function testEditPageAsAnonymousTaskAction()
    {
        $task = $this->createTask(null);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/edit');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testEditPageAsUserTaskAction()
    {
        $user = $this->logInAs('user');
        $task = $this->createTask($user);

        $crawler = $this->client->request('GET', 'tasks/'. $task->getId() .'/edit');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Titre")')->count());
    }

    /**
     *
     */
    public function testEditPageAsAdminTaskAction()
    {
        $admin = $this->logInAs('admin');
        $task = $this->createTask($admin);

        $crawler = $this->client->request('GET', 'tasks/'. $task->getId() .'/edit');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Titre")')->count());
    }

    /**
     *
     */
    public function testEditTaskAction()
    {
        $user = $this->logInAs('user');
        $task = $this->createTask($user);

        $crawler = $this->client->request('GET', 'tasks/'. $task->getId() .'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Ma 1ère tâche modifiée';
        $form['task[content]'] = 'Ma 1ère tâche modifiée';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a bien été modifiée.")')->count());

    }

    /**
     *
     */
    public function testToggleTaskAsAnonymousAction()
    {
        $task = $this->createTask(null);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/toggle');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testToggleTaskAsUserAction()
    {
        $user = $this->logInAs('user');
        $task = $this->createTask($user);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/toggle');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("a bien été marquée comme faite.")')->count());
    }

    /**
     *
     */
    public function testToggleTaskAsAdminAction()
    {
        $admin = $this->logInAs('admin');
        $task = $this->createTask($admin);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/toggle');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("a bien été marquée comme faite.")')->count());
    }

    /**
     *
     */
    public function testDeleteTaskAsUserAction()
    {
        $user = $this->logInAs('user');
        $task = $this->createTask($user);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }

    /**
     *
     */
    public function testDeleteTaskAsNotGoodUserAction()
    {
        $this->logInAs('user');

        $user = $this->createUser('ROLE_USER');
        $task = $this->createTask($user);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');

        $response = $this->client->getResponse();

        $this->assertSame(500, $response->getStatusCode());
    }

    /**
     *
     */
    public function testDeleteTaskAsAdminAction()
    {
        $admin = $this->logInAs('admin');
        $task = $this->createTask($admin);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }

    /**
     *
     */
    public function testDeleteAnonymousTaskAsAdminAction()
    {
        $this->logInAs('admin');

        $task = $this->createTask(null);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }

    /**
     *
     */
    public function testDeleteAnonymousTaskAsUserAction()
    {
        $this->logInAs('user');

        $task = $this->createTask(null);

        $this->client->request('GET', 'tasks/'. $task->getId() .'/delete');

        $response = $this->client->getResponse();
        $this->assertSame(500, $response->getStatusCode());
    }
}