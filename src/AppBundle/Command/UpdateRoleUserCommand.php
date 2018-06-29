<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 04/06/2018
 * Time: 20:40
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateRoleUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('todolist:updateroleuser')
            ->setDescription('Set ROLE_USER to user without roles')
            ->setHelp('Set ROLE_USER to user without roles')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $users = $em->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user) {
            if (empty($user->getRole())) {
                $user->setRole('ROLE_USER');
            }
            $em->flush();
        }
        $output->writeln('The users without roles are updated with the role ROLE_USER.');
    }
}
