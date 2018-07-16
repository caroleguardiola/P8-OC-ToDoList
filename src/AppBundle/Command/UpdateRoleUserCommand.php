<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 04/06/2018
 * Time: 20:40
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateRoleUserCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('todolist:updateroleuser')
            ->setDescription('Set ROLE_USER to user without roles')
            ->setHelp('Set ROLE_USER to user without roles')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $users = $entityManager->getRepository('AppBundle:User')->findAll();

        foreach ($users as $user) {
            if (empty($user->getRole())) {
                $user->setRole('ROLE_USER');
            }
            $entityManager->flush();
        }
        $output->writeln('The users without roles are updated with the role ROLE_USER.');
    }
}
