<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 08/06/2018
 * Time: 18:02
 */

namespace Tests\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command\UpdateRoleUserCommand;


class UpdateRoleUserCommandTest extends WebTestCase
{
    private $client = null;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testExecuteCommandRole()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new UpdateRoleUserCommand());

        $command = $application->find('todolist:updateroleuser');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));
        
        $output = $commandTester->getDisplay();
        $this->assertContains('The users without roles are updated with the role ROLE_USER.', $output);
    }
}