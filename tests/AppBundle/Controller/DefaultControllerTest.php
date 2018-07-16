<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\AppWebTestCase;

class DefaultControllerTest extends AppWebTestCase
{
    /**
     *
     */
    public function testIndexAsAnonymous()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    /**
     *
     */
    public function testIndexAsUser()
    {
        $this->logInAs('user');

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    /**
     *
     */
    public function testIndexAsAdmin()
    {
        $this->logInAs('admin');

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }
}
