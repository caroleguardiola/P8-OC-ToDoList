<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 12/06/2018
 * Time: 20:33
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

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command\LoadDatasCommand;

class LoadDatasCommandTest extends KernelTestCase
{
    /**
     *
     */
    public function testExecuteLoadDatasCommand()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new LoadDatasCommand());

        $command = $application->find('todolist:loaddatas');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Database schema updated successfully!', $output);
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->client = null;
    }
}