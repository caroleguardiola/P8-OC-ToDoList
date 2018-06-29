<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 09:44
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\AppWebTestCase;

class SecurityControllerTest extends AppWebTestCase
{
    /**
     *
     */
    public function testLoginIsUp()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testLogin()
    {
        $user = $this->createUserForLogin('ROLE_USER', 'password');

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $user->getUsername();
        $form['_password'] = 'password';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    /**
     *
     */
    public function testLoginInvalidUsername()
    {
        $this->createUserForLogin('ROLE_USER', 'password');

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalid_username';
        $form['_password'] = 'password';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
    }

    /**
     *
     */
    public function testLoginInvalidPassword()
    {
        $user = $this->createUserForLogin('ROLE_USER', 'password');

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = $user->getUsername();
        $form['_password'] = 'invalid_password';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
    }

    /**
     *
     */
    public function testLoginInvalidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalid_username';
        $form['_password'] = 'invalid_password';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials")')->count());
    }

    /**
     *
     */
    public function testLogout()
    {
        $this->logInAs('user');

        $this->client->request('GET', '/logout');
        $this->client->followRedirect();

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }
}