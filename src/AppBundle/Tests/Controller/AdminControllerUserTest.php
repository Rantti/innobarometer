<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/9/2015
 * Time: 9:29 AM
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerUserTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/login');

        //Test that page loads and gives code 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // Check that titles matches "MobileBarometer"
        $this->assertContains('MobileBarometer', $crawler->filter('title')->text());

        // Login as Admin
        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'adminpera';
        $form['_password'] = '12345';

        // submit the form, need to put a couple assertation here
        $crawler = $client->submit($form);

        //Test that the page contains text ROLE_ADMIN
        $this->assertContains('ROLE_ADMIN', $crawler->filter('html')->text());

        //click the link and go to Statements
        $link = $crawler->filter('a:contains("Users")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that page loads.
        $this->assertContains('User Administration', $crawler->filter('h1')->text());

        //Log out
        $link = $crawler->filter('a:contains("Log out")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Overview
        $this->assertContains('Sign up', $crawler->filter('html')->text());


    }


}
