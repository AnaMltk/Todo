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
        $this->assertSame(1, $crawler->filter('html:contains("Créé par user")')->count());


    }

    public function testCreateActionByLoggedInUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/create');
        $client->submitForm('Ajouter', [
            'task'=>[
            'title' => 'task test',
            'content' =>'task test',
            ],

        ]);
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("La tâche a été bien été ajoutée")')->count());
        
    }

    public function testCreateActionByNotLoggedInUser()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/create');
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur")')->count());

    }

    public function testEditActionByAdmin()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/edit');
        $client->submitForm('Modifier', [
            'task'=>[
            'title' => 'task modified',
            'content' =>'task modified',
            ],
        ]);
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("La tâche a bien été modifiée")')->count());
       
    }

    public function testEditActionByUserWhoCreatedTask()
    {
        $taskId = 1;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/edit');
        $client->submitForm('Modifier', [
            'task'=>[
            'title' => 'task modified',
            'content' =>'task modified',
            ],
        ]);

        $crawler = $client->followRedirect();
    
        $this->assertSame(1, $crawler->filter('html:contains("La tâche a bien été modifiée")')->count());
    }

    public function testEditActionByUserWhoDidNotCreateTask()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/tasks/'.$taskId.'/edit');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    public function testDeleteTaskActionByAdmin()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/delete');
        $crawler = $client->followRedirect();
       
        $this->assertSame(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
        
    }

    public function testDeleteActionByUserWhoCreatedTask()
    {
        $taskId = 1;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/delete');
        $crawler = $client->followRedirect();
    
        $this->assertSame(1, $crawler->filter('html:contains("La tâche a bien été supprimée")')->count());
    }

    public function testDeleteActionByUserWhoDidNotCreateTask()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/tasks/'.$taskId.'/delete');
        
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    public function testToggleTaskActionByAdmin()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/toggle');
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Superbe ! ")')->count());
    }

    public function testToggleTaskActionByUserWhoCreatedTask()
    {
        $taskId = 1;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $client->request('GET', '/tasks/'.$taskId.'/toggle');
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Superbe ! ")')->count());
    }

    public function testToggleTaskActionByUserWhoDidNotCreateTask()
    {
        $taskId = 2;
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(2);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/tasks/'.$taskId.'/toggle');

        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }
    

}