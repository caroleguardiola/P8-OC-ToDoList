<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 12/06/2018
 * Time: 18:34
 */

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as WTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use AppBundle\Command\LoadDatasCommand;
use Symfony\Component\Console\Tester\CommandTester;


class WebTestCase extends WTestCase
{
    protected $client = null;
    protected $container;
    protected $entityManager;

    /**
     *
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();

        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new LoadDatasCommand());

        $command = $application->find('todolist:loaddatas');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));
    }

    /**
     *
     */
    protected function logInAsUser()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = 'main';

        //$user is in DB as Lisy in username and ROLE_USER in role
        $user = $this->entityManager->getRepository(User::class)->findOneByUsername('Lisy');

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     *
     */
    protected function logInAsAdmin()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = 'main';

        //$user is in DB as Anna in username and ROLE_ADMIN in role
        $user = $this->entityManager->getRepository(User::class)->findOneByUsername('Anna');

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown()
    {
        $this->client = null;
        $this->container = null;
        $this->entityManager->close();
        $this->entityManager = null;
    }
}