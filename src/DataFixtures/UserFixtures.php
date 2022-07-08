<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture 
{
    public $encoder;
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const USER_REFERENCE = 'user';
    public const ANONYMOUS_USER_REFERENCE = 'anonymous-user';

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        //user admin
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setUserName('admin');
        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

        //user 
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setUserName('user');
        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE, $user);

        //anonymous user
        $user = new User();
        $user->setEmail('anonyme@gmail.com');
        $user->setUserName('anonyme');
        $password = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $this->addReference(self::ANONYMOUS_USER_REFERENCE, $user);

        $manager->flush();
        
    }
}
