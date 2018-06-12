<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 09:44
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\SetUpTest;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends SetUpTest
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
        $crawler = $this->client->request('GET', '/login');

        //This user with username Lisy and password lisy is in DB
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Lisy';
        $form['_password'] = 'lisy';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    /**
     *
     */
    public function testLoginInvalidCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());

        //This user with username invalid_username and password invalid_password is not in DB
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
        $this->loginAsUser();

        $this->client->request('GET', '/logout');
        $this->client->followRedirect();

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }
}