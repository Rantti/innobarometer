<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/8/2015
 * Time: 7:56 PM
 */

namespace  AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Login)')->count());
    }

    public function testSecureSection()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/login');

        // redirects to the login page
        $crawler = $client->followRedirect();

        // submits the login form
        $form = $crawler->selectButton('Login')->form(array('_username' => 'pera', '_password' => '12345'));
        $client->submit($form);

        // redirect to the original page (but now authenticated)
        $crawler = $client->followRedirect();

        // check that the page is the right one
        $this->assertCount(1, $crawler->filter('h1.title:contains("Hello World!")'));

        // click on the secure link
       // $link = $crawler->selectLink('Hello resource secured')->link();
       // $crawler = $client->click($link);

        // check that the page is the right one
        $this->assertCount(1, $crawler->filter('h1.title:contains("Admin")'));
    }
}
