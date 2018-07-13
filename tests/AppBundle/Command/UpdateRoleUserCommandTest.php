<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 08/06/2018
 * Time: 18:02
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Command;

use Tests\AppBundle\AppWebTestCase;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Doctrine\ORM\EntityManager;
use AppBundle\Repository\UserRepository;


class UpdateRoleUserCommandTest extends AppWebTestCase
{
    /**
     * @param $repositories
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function mockRepositories($repositories)
    {
        $EntityManager = $this->createMock(EntityManager::class);

        $EntityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositories));

        $this->client->getcontainer()->set('doctrine.orm.default_entity_manager', $EntityManager);

        return $EntityManager;
    }

    /**
     * @param $role
     * @return User
     */
    protected function createUserForCommand($role)
    {
        $reflectionClass = new \ReflectionClass(User::class);

        $user = new User;
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($user, random_int(1,10000));
        $user->setUsername('user'.random_int(1,10000));
        $user->setEmail('email'.random_int(1,10000).'@example.com');
        $user->setRole($role);
        $user->setPassword('password');

        return $user;
    }

    /**
     * @throws \Exception
     */
    public function testExecuteCommandRole()
    {
        $userWithoutRole = $this->createUserForCommand(null);
        $userWithUserRole = $this->createUserForCommand('ROLE_USER');
        $userWithAdminRole = $this->createUserForCommand('ROLE_ADMIN');

        //Mock UserRepository
        $userRepository = $this->createMock(UserRepository:: class);

        $userRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$userWithoutRole, $userWithUserRole, $userWithAdminRole]);

        $EntityManager = $this->mockRepositories([
            ['AppBundle:User', $userRepository],
        ]);

        $EntityManager
            ->expects($this->atLeastOnce())
            ->method('flush');

        //Run Command todolist:updateroleuser
        $application = new Application($this->client->getKernel());
        $application->setAutoExit(false);
        $application->run(new ArrayInput([
            'command' => 'todolist:updateroleuser',
        ]), new NullOutput());

        //Check Command todolist:updateroleuser ok and others roles not changed
        $this->assertSame(['ROLE_USER'], $userWithoutRole->getRoles());
        $this->assertSame(['ROLE_USER'], $userWithUserRole->getRoles());
        $this->assertSame(['ROLE_ADMIN'], $userWithAdminRole->getRoles());

    }
}