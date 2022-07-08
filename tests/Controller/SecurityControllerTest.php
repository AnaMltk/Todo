<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class SecurityControllerTest extends WebTestCase
{
    public function testLoginActionWrongCredentials()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
                        '_username' => 'test2',
                        '_password' => 'test',
                    ]);
        
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur")')->count());
    }

    public function testLoginAction()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Se connecter', [
                        '_username' => 'admin',
                        '_password' => 'password',
                    ]);
        
        $this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Se déconnecter")')->count());
    }

}