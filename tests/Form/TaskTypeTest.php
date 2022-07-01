<?php

namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use App\Controller\TaskController;
use DateTime;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTypeTest extends TypeTestCase
{
    
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'test3',
            'content' => 'test2',
        ];
        $model = new Task();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $model);
        $model->setCreatedAt(new DateTime('2022-06-01'));
        $expected = new Task();
        // ...populate $object properties with the data stored in $formData
        $expected->setTitle($formData['title']);
        $expected->setContent($formData['content']);
        $expected->setCreatedAt(new DateTime('2022-06-01'));
        
        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
