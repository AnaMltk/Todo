<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListActionByAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());

    }

    public function testListActionByUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/users');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());

    }

    public function testCreateActionByAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/users/create');
        $client->submitForm('Ajouter', [
            'user' => [
                'username' => 'test',
                'email' => 'test@test.com',
                'password' => [
                    'first' => '123456',
                    'second' => '123456'
                ],
                'roles' => 'ROLE_USER'
            ],

        ]);
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
        
    }

    public function testCreateActionByUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/users/create');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    public function testEditActionByAdmin()
    {
      $client = static::createClient();
      $userRepository = static::getContainer()->get(UserRepository::class);
      $user = $userRepository->find(1);
      $client->loginUser($user);
      $userId = 2;
      $client->request('GET', '/users/'.$userId.'/edit');
      $client->submitForm('Modifier', [
        'user' => [
            'username' => 'testEdit',
            'email' => 'test@test.com',
            'password' => [
                'first' => '123456',
                'second' => '123456'
            ],
            'roles' => 'ROLE_ADMIN'
        ],

    ]);
    $crawler = $client->followRedirect();

    $this->assertResponseIsSuccessful();
    $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    public function testEditActionByUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/users/create');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }
}
