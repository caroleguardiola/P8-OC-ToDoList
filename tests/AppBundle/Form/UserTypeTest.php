<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 19/06/2018
 * Time: 21:29
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\Form\Test\FormIntegrationTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTypeTest extends FormIntegrationTestCase
{
    private $validator;

    /**
     * @return array
     */
    protected function getExtensions()
    {
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));

        $this->validator
            ->method('getMetadataFor')
            ->will($this->returnValue(new ClassMetadata(Form::class)));

        return [
            new ValidatorExtension($this->validator),
        ];
    }

    /**
     * @param $username
     * @param $email
     * @param $role
     * @param $password
     * @return User
     */
    protected function createUserForSubmitForm($username, $email, $role, $password)
    {
        $user = new User;
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRole($role);
        $user->setPassword($password);

        return $user;
    }

    /**
     *
     */
    public function testSubmitValidDataUser()
    {
        $user = $this->createUserForSubmitForm('Anna', 'anna@example.com', 'ROLE_ADMIN', 'password');

        $formData = [
            'username' => 'Anna',
            'password' => ['first' => 'password', 'second' => 'password'],
            'email' => 'anna@example.com',
            'role' => 'ROLE_ADMIN',
        ];

        $form = $this->factory->create(UserType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user->getUsername(), $form->get('username')->getData());
        $this->assertEquals($user->getPassword(), $form->get('password')->getData());
        $this->assertEquals($user->getEmail(), $form->get('email')->getData());
        $this->assertEquals($user->getRole(), $form->get('role')->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
