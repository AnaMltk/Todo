<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
         $task = new Task();
         $task->setTitle('test');
         $task->setContent('test');
         $task->setCreatedAt(new DateTime());
         
         $task->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));

         $manager->persist($task);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
