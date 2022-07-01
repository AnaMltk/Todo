<?php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Persistence\ManagerRegistry;


Class TaskControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();

    }

    public function testCreateAction()
    {
        //$user = $this->repo->find(1);
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/create');
        //$form = $client->selectButton('Ajouter')
        $client->submitForm('Ajouter', [
            'task'=>[
            'title' => 'test',
            'content' =>'test',
            ],

        ]);
        //$this->assertResponseStatusCodeSame(201);
        //$this->assertResponseIsSuccessful();
        $this->assertResponseRedirects();
        $client->followRedirect();
    }

    public function testEditAction()
    {
        $taskId = 1;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/edit');
        $client->submitForm('Modifier', [
            'task'=>[
            'title' => 'test2',
            'content' =>'test',
            ],
        ]);

        //$this->assertResponseIsSuccessful();
        $this->assertResponseRedirects();
        //$client->followRedirect();
       
    }

    public function testDeleteTaskAction()
    {
        $taskId = 1;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/delete');
        
        //$this->assertResponseStatusCodeSame(204);
        $this->assertResponseRedirects();
        //$client->followRedirect();

    }

    public function testToggleTaskAction()
    {
        $taskId = 1;
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks/'.$taskId.'/toggle');
        
        //$this->assertResponseRedirects();
        $crawler = $client->followRedirect();
        //var_dump($crawler); die;
        $this->assertSame(1, $crawler->filter('html:contains("La tâche test a bien été marquée comme faite.")')->count());
    }
    

}