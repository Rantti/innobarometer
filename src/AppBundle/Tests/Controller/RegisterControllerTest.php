<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegistration()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/login');
        // Test that page loads and gives code 200
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // Check that titles matches "MobileBarometer"
        $this->assertContains('MobileBarometer', $crawler->filter('title')->text());

        //click the link and go to Sign Up
        $link = $crawler->filter('a:contains("Sign up")')->eq(0)->link();
        $crawler = $client->click($link);

        // Test that page contains Repeat password
        $this->assertContains('MobileBarometer', $crawler->filter('title')->text());

        // Register new account
        $form = $crawler->filter('form')->form();
        $crawler = $client->submit($form, array('fos_user_registration_form[email]' => 'asd@testasd.asd',
                                                'fos_user_registration_form[username]' => 'testpera1',
                                                'fos_user_registration_form[plainPassword][first]' => '12345',
                                                'fos_user_registration_form[plainPassword][second]' => '12345'));

        // Test that page contains Repeat password
        $this->assertContains('The user has been created successfully', $crawler->filter('html')->text());

        // dump the variables to console
        //var_dump($client->getResponse()->getContent());
    }


}
