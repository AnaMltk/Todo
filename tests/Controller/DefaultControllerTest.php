<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

Class DefaultControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

}