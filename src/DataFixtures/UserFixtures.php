<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture 
{
    public $encoder;
    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setEmail('test@test.com');
         $user->setUserName('test');
         $password = $this->encoder->encodePassword($user, 'test');
         $user->setPassword($password);
         $user->setRoles(['ROLE_ADMIN']);
         $manager->persist($user);

        $manager->flush();
        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }
}
