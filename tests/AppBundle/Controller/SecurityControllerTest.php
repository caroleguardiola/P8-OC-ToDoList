<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 06/06/2018
 * Time: 09:44
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use AppBundle\Entity\User;

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

    private function logInAsUser()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $user = $this->client->getContainer()->get('doctrine')->getRepository(User::class)->find(1);

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, array('ROLE_USER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
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

    public function testLogout()
    {
        $this->logInAsUser();

        $this->client->request('GET', '/logout');
        $this->client->followRedirect();

        $response = $this->client->getResponse();
        $this->assertSame(302, $response->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }
}