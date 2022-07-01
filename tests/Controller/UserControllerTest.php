<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateAction()
    {
        $client = static::createClient();
        $client->request('GET', '/users/create');
        //$form = $client->selectButton('Ajouter')
        $client->submitForm('Ajouter', [
            'user' => [
                'username' => 'test9',
                'email' => 'test9@test.com',
                'password' => [
                    'first' => '123456',
                    'second' => '123456'
                ]
            ],

        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
    }

    public function testEditAction()
    {
      $client = static::createClient();
      $userId = 1;
      $client->request('GET', '/users/'.$userId.'/edit');
      $client->submitForm('Modifier', [
        'user' => [
            'username' => 'testEdit',
            'email' => 'test9@test.com',
            'password' => [
                'first' => '123456',
                'second' => '123456'
            ]
        ],

    ]);
    $this->assertResponseRedirects();
    //$client->followRedirect();
    }
}
