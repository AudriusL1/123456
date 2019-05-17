<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\src\Controller\register;
use Symfony\Component\Routing\Annotation\Route;

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
            $crawler->filter('html:contains("Enter your username and password")')->count()
        );

    }
    public  function testLoginForm(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'mildaliux';
        $form['_password'] = '12345';
        $client->submit($form);

    }


}