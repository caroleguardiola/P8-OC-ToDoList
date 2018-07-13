<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 12/06/2018
 * Time: 18:34
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;


class AppWebTestCase extends WebTestCase
{
    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * @return Client
     */
    public function getNewClient()
    {
        return $this->client = static::createClient();
    }

    /**
     * @return null|Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @throws \Exception
     */
    public function resetDatabase(Client $client)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);
        $application->run(new ArrayInput([
            'command' => 'doctrine:schema:drop',
            '--no-interaction' => true,
            '--force' => true,
            '--env' => 'test',
        ]), new NullOutput());
        $application->run(new ArrayInput([
            'command' => 'doctrine:schema:create',
            '--no-interaction' => true,
            '--env' => 'test',
        ]), new NullOutput());
        $application->run(new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--no-interaction' => true,
            '--env' => 'test',
        ]), new NullOutput());

        $this->client = static::createClient();
    }

    /**
     * @return object
     */
    public function getEntityManager()
    {
        return $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @return object
     */
    public function getSecurityPasswordEncoder()
    {
        return $this->client->getContainer()->get('security.password_encoder');
    }

    /**
     * @param $role
     * @return User
     */
    protected function createUser($role)
    {
        $user = new User;
        $user->setUsername('user'.random_int(1,10000));
        $user->setEmail('email'.random_int(1,10000).'@example.com');
        $user->setRole($role);

        $passwordEncoder = $this->getSecurityPasswordEncoder();
        $passwordEncode = $passwordEncoder->encodePassword($user, 'password');
        $user->setPassword($passwordEncode);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param $role
     * @param $password
     * @return User
     */
    protected function createUserForLogin($role, $password)
    {
        $user = new User;
        $user->setUsername('user'.random_int(1,10000));
        $user->setEmail('email'.random_int(1,10000).'@example.com');
        $user->setRole($role);

        $passwordEncoder = $this->getSecurityPasswordEncoder();
        $passwordEncode = $passwordEncoder->encodePassword($user, $password);
        $user->setPassword($passwordEncode);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * @param $user
     * @return Task
     */
    protected function createTask($user)
    {
        $task = new Task;
        $task->setTitle('Tâche'.random_int(1,10000));
        $task->setContent('Contenu de la tâche de test.');
        $task->setUser($user);

        $this->getEntityManager()->persist($task);
        $this->getEntityManager()->flush();

        return $task;
    }

    /**
     * @param $username
     * @return mixed
     */
    protected function logInAs($username)
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = 'main';

        $user = $this->client->getContainer()->get('doctrine')->getManager()->getRepository(User::class)->findOneByUsername($username);

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, $user->getRoles());

        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

        return $user;
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->client = null;
    }
}