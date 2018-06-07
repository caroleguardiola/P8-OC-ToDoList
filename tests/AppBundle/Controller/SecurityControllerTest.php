<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 09:44
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

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

        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Lisy';
        $form['_password'] = 'lisy';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }
}