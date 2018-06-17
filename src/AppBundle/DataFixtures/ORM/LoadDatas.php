<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 12/06/2018
 * Time: 14:17
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadDatas implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //Users
        $user1 = new User;
        $user1->setUsername('Lisy');
        $user1->setEmail('lisy.moon@gmail.com');
        $user1->setRole('ROLE_USER');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user1, 'lisy');
        $user1->setPassword($password);

        $manager->persist($user1);

        $user2 = new User;
        $user2->setUsername('Anna');
        $user2->setEmail('anna.dillo@gmail.com');
        $user2->setRole('ROLE_ADMIN');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user2, 'anna');
        $user2->setPassword($password);

        $manager->persist($user2);

        $user3 = new User;
        $user3->setUsername('Tally');
        $user3->setEmail('tally.nolan@gmail.com');
        $user3->setRole('ROLE_USER');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user3, 'tally');
        $user3->setPassword($password);

        $manager->persist($user3);

        //Tasks
        $task1 = new Task;
        $task1->setTitle('1ère tâche');
        $task1->setContent('Contenu de la 1ère tâche.');
        $task1->setUser($user1);
        $manager->persist($task1);

        $task2 = new Task;
        $task2->setTitle('2ème tâche');
        $task2->setContent('Contenu de la 2ème tâche.');
        $task2->setUser($user2);
        $manager->persist($task2);

        $task3 = new Task;
        $task3->setTitle('3ème tâche');
        $task3->setContent('Contenu de la 3ème tâche.');
        $task3->setUser(null);
        $manager->persist($task3);

        $task4 = new Task;
        $task4->setTitle('4ème tâche');
        $task4->setContent('Contenu de la 4ème tâche.');
        $task4->setUser($user1);
        $manager->persist($task4);

        $task5 = new Task;
        $task5->setTitle('5ème tâche');
        $task5->setContent('Contenu de la 5ème tâche.');
        $task5->setUser($user3);
        $manager->persist($task5);

        // On déclenche l'enregistrement
        $manager->flush();
    }
}