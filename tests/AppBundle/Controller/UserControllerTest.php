<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 18:02
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\SetUpTest;


class UserControllerTest extends SetUpTest
{
    public function testListUsersWithAdminAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    public function testListUsersWithUserAction()
    {
        //user has not the permission to access to the management of the users
        $this->logInAsUser();

        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testCreatePageUserAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
    }

    public function testCreateUserAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'user';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'user@gmail.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été ajouté.")')->count());

    }

    public function testCreateAdminAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'admin';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'admin@gmail.com';
        $form['user[role]'] = 'ROLE_ADMIN';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été ajouté.")')->count());

    }

    public function testEditPageUserAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users/3/edit');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Modifier")')->count());
    }

    public function testEditUserAction()
    {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/users/3/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'Jake';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'jake@gmail.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été modifié.")')->count());

    }
}