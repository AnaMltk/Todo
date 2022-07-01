<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class SecurityControllerTest extends WebTestCase
{
    public function testLoginAction()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
                        '_username' => 'test2',
                        '_password' => 'test',
                    ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
    }

}