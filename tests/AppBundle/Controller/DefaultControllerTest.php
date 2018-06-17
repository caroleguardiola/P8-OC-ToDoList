<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     *
     */
    public function testIndexAsUser()
    {
        $this->loginAsUser();

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());

    }

    /**
     *
     */
    public function testIndexAsAdmin()
    {
        $this->loginAsAdmin();

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());

    }
}
