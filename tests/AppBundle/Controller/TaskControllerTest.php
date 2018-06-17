<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 16:15
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\WebTestCase;


class TaskControllerTest extends WebTestCase
{
    public function testListTasksAction()
    {
        $this->logInAsUser();

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    public function testCreatePageTaskAction()
    {
        $this->logInAsUser();

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Title")')->count());
    }

    public function testCreateTaskAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Ma 1ère tâche';
        $form['task[content]'] = 'Ma 1ère tâche';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a été bien été ajoutée.")')->count());

    }

    public function testEditPageTaskAction()
    {
        $this->logInAsUser();

        //tasks 1 is a Lisy's task
        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Title")')->count());
    }

    public function testEditTaskAction()
    {
        $this->logInAsUser();

        //tasks 1 is a Lisy's task
        $crawler = $this->client->request('GET', '/tasks/1/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Ma 1ère tâche modifiée';
        $form['task[content]'] = 'Ma 1ère tâche modifiée';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a bien été modifiée.")')->count());

    }

    public function testToggleTaskAction()
    {
        $this->logInAsUser();

        //tasks 1 is a Lisy's task
        $crawler = $this->client->request('GET', '/tasks/1/toggle');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("La tâche 1ère tâche a bien été marquée comme faite.")')->count());
    }

    public function testDeleteTaskWithUserAction()
    {
        $this->logInAsUser();

        //tasks 4 is a Lisy's task
        $crawler = $this->client->request('GET', '/tasks/4/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }

    public function testDeleteTaskWithNotGoodUserAction()
    {
        $this->logInAsUser();

        //tasks 5 is not a Lisy's task
        $crawler = $this->client->request('GET', '/tasks/5/delete');

        $response = $this->client->getResponse();

        //$this->expectException(\Exception::class);
        //$this->expectExceptionMessage('Vous n\'avez pas la permission de supprimer cette tâche.');

        $this->assertSame(500, $response->getStatusCode());
    }

    public function testDeleteTaskwithAdminAction()
    {
        $this->logInAsAdmin();

        //tasks 2 is a Anna's task
        $crawler = $this->client->request('GET', '/tasks/2/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }

    public function testDeleteAnonymousTaskwithAdminAction()
    {
        $this->logInAsAdmin();

        //tasks 3 is a Anonymous' task
        $crawler = $this->client->request('GET', '/tasks/3/delete');

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! La tâche a bien été supprimée.")')->count());
    }
}