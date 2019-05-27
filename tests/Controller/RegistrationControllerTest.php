<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\src\Controller\register;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class RegistrationControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
    public function testTitleText(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Go back")')->count()
        );

    }
    //public  function testLoginForm(){
      //  $client = static::createClient();
      //  $crawler = $client->request('GET', '/login');
      //  $form = $crawler->selectButton('Login')->form();
      //  $form['_username'] = 'mildaliux';
      //  $form['_password'] = '12345';
      //  $client->submit($form);

//    }

    public function testNameChange()
    {
      $user = new user();
      $user->setUsername('testinis');
      $user->setEmail('kr@kk.tv');

      $this->assertEquals($user->getUsername(), 'testinis');
      $this->assertEquals($user->getEmail(), 'kr@kk.tv');
    }

    public function testDefoultRole()
    {
      $user = new user();
      $this->assertEquals($user->getRole(), 0);
    }




}
