<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 03/06/2018
 * Time: 21:33
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUserAnonymousCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('todolist:updatetaskswithoutuser')
            ->setDescription('Link the tasks already created without user to the user anonymous')
            ->setHelp('Link the tasks already created without user to the user anonymous')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tasks = $em->getRepository('AppBundle:Task')->findAll();

        foreach ($tasks as $task) {
            if (empty($task->getUser())) {
                $task->setUser(null);
            }
            $em->flush();
        }
        $output->writeln('The tasks already created without user are connected to the user anonymous.');
    }
}