<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAdd()
    {
        $user = new User();
        $user->setUserName('test');
        $user->setEmail('test@test.com');
        $user->setPassword('test');
        $user->setRoles(['ROLE_USER']);

        $this->entityManager
        ->getRepository(User::class)
        ->add($user);

        $newUser = $this->entityManager
        ->getRepository(User::class)
        ->findBy(['email' => 'test@test.com']);

        $this->assertNotNull($newUser);
    }

    public function testRemove()
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->find(1);
        $this->entityManager
        ->getRepository(User::class)
        ->remove($user);

        $userUpdated = $this->entityManager
        ->getRepository(User::class)
        ->find(1);

        $this->assertNull($userUpdated);
    }

    public function testUpgradePassword()
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->find(1);
        $oldPassword = $user->getPassword();
        $hash = '$2y$04$KUnqNniY4FVlAakkdRGEU.ltBWnR3kcox4JJ2ZK6qJCBfzGThcJyb';
        $this->entityManager
        ->getRepository(User::class)
        ->upgradePassword($user, $hash);
        $updatedUser = $this->entityManager
        ->getRepository(User::class)
        ->find(1);
        $updatedPassword = $updatedUser->getPassword();

        $this->assertNotSame($oldPassword, $updatedPassword);
    }
}
