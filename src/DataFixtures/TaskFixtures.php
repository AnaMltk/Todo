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
        $task->setTitle('task user');
        $task->setContent('task user');
        $task->setCreatedAt(new DateTime());
         
        $task->setUser($this->getReference(UserFixtures::USER_REFERENCE));

        $manager->persist($task);

        $task = new Task();
        $task->setTitle('task anonyme');
        $task->setContent('task anonyme');
        $task->setCreatedAt(new DateTime());
         
        $task->setUser($this->getReference(UserFixtures::ANONYMOUS_USER_REFERENCE));

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
