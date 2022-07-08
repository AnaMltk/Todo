<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

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
            'roles' => 'ROLE_ADMIN'
        ];
        $model = new User();
        
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserType::class, $model);
        
        $expected = new User();
        // ...populate $object properties with the data stored in $formData
        $expected->setUserName($formData['username']);
        $expected->setPassword($formData['password']['first']);
        $expected->setEmail($formData['email']);
        $expected->setRoles(['ROLE_ADMIN']);
        
        // submit the data to the form directly
        $form->submit($formData);
    
        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());
        
        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
