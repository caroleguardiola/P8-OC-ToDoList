<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 12/06/2018
 * Time: 17:09
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class LoadDatasCommand extends ContainerAwareCommand
{
    /**
     * Configure command options
     */
    protected function configure()
    {
        $this
            ->setName('todolist:loaddatas')
            ->setDescription('Initialize database for tests.')
            ->setHelp('Set datas for tests.')
        ;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();

        //Delete the existing DB
        $createdbCmd = $application->find('doctrine:database:drop');
        $createdbInput = new ArrayInput(['command' => 'doctrine:database:drop', '--force' => true, '--if-exists' => true]);
        $createdbCmd->run($createdbInput, $output);

        //Create the DB
        $createdbCmd = $application->find('doctrine:database:create');
        $createdbInput = new ArrayInput(['command' => 'doctrine:database:create']);
        $createdbCmd->run($createdbInput, $output);

        //Create the schema
        $createtablesCmd = $application->find('doctrine:schema:update');
        $createtablesInput = new ArrayInput(['command' => 'doctrine:schema:update', '--force' => true]);
        $createtablesCmd->run($createtablesInput, $output);

        //Load the datas
        $loaddataCmd = $application->find('doctrine:fixtures:load');
        $loaddataInput = new ArrayInput(['command' => 'doctrine:fixtures:load']);
        $loaddataInput->setInteractive(false);
        $loaddataCmd->run($loaddataInput, $output);
    }
}
