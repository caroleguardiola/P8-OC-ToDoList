<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 18:02
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\AppWebTestCase;

class UserControllerTest extends AppWebTestCase
{
    /**
     *
     */
    public function testListUsersAsAnonymousAction()
    {
        $this->client->request('GET', '/users');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testListUsersAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    /**
     *
     */
    public function testListUsersAsUserAction()
    {
        //user has not the permission to access to the management of the users
        $this->logInAs('user');

        $this->client->request('GET', '/users');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testConsultListButtonUserAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Consulter la liste des utilisateurs')->link();
        $crawler = $this->client->click($link);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
    }

    /**
     *
     */
    public function testCreateButtonUserAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Créer un nouvel utilisateur')->link();
        $crawler = $this->client->click($link);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Nom")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    /**
     *
     */
    public function testCreatePageUserAsAnonymousAction()
    {
        $this->client->request('GET', '/users/create');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testCreatePageUserAsAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/users/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
    }

    /**
     *
     */
    public function testCreatePageUserAsUserAction()
    {
        $this->logInAs('user');

        $this->client->request('GET', '/users/create');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testCreateUserAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'Molly';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'molly@example.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été ajouté.")')->count());

    }

    /**
     *
     */
    public function testCreateAdminAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'Ben';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'ben@example.com';
        $form['user[role]'] = 'ROLE_ADMIN';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été ajouté.")')->count());

    }

    /**
     *
     */
    public function testCreateUserEmptyAction()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = '';
        $form['user[password][first]'] = '';
        $form['user[password][second]'] = '';
        $form['user[email]'] = '';
        $crawler = $this->client->submit($form);

        $this->assertSame(1, $crawler->filter('html:contains(" Vous devez saisir un nom d\'utilisateur")')->count());
        $this->assertSame(1, $crawler->filter('html:contains(" Vous devez saisir une adresse email")')->count());
        $this->assertSame(1, $crawler->filter('html:contains(" Vous devez choisir un rôle")')->count());

    }

    /**
     *
     */
    public function testEditPageUserAsAnonymousAction()
    {
        $user = $this->createUser('ROLE_USER');

        $this->client->request('GET', 'users/'. $user->getId() .'/edit');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testEditPageUserAsAdminAction()
    {
        $this->logInAs('admin');

        $user = $this->createUser('ROLE_USER');

        $crawler = $this->client->request('GET', 'users/'. $user->getId() .'/edit');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Modifier")')->count());
    }

    /**
     *
     */
    public function testEditPageUserAsUserAction()
    {
        $this->logInAs('user');

        $user = $this->createUser('ROLE_USER');

        $this->client->request('GET', 'users/'. $user->getId() .'/edit');

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testEditUserAction()
    {
        $this->logInAs('admin');

        $user = $this->createUser('ROLE_USER');

        $crawler = $this->client->request('GET', 'users/'. $user->getId() .'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = $user->getUsername();
        $form['user[password][first]'] = 'secret';
        $form['user[password][second]'] = 'secret';
        $form['user[email]'] = $user->getEmail();
        $form['user[role]'] = $user->getRole();
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("L\'utilisateur a bien été modifié.")')->count());

    }
}