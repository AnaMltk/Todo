<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use App\Controller\UserController;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'username' => 'test',
        
                'password' => [
                    'first' => '123456',
                    'second' => '123456',
                ],
            

            'email' => 'test2',
        ];
        $model = new User();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserType::class, $model);

        $expected = new User();
        // ...populate $object properties with the data stored in $formData
        $expected->setUserName($formData['username']);
        $expected->setPassword($formData['password']['first']);
        $expected->setEmail($formData['email']);
        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
