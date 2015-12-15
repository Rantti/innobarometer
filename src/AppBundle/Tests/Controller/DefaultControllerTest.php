<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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
        $form['_username'] = 'pera';
        $form['_password'] = '12345';

        // submit the form
        $crawler = $client->submit($form);

        //Test that the page contains text Welcome to Mobile Barometer!
        $this->assertContains('Welcome to Mobile Barometer', $crawler->filter('html')->text());


        // check that the page is the right one



        //click the link and go to Create Statement
        $link = $crawler->filter('a:contains("My Questionnaires")')->eq(0)->link();
        $crawler = $client->click($link);


        $this->assertContains('My questionnaires', $crawler->filter('html')->text());

        $link = $crawler->filter('a:contains("Fill questionnaire")')->eq(0)->link();
       $crawler = $client->click($link);

        $this->assertContains('Fill in the Q', $crawler->filter('html')->text());

        $form = $crawler->filter('form')->form();
        //$form->select ('form select[name=3]', '1');
       // $form['3[]']->select('1');
       // $form['4[]']->select('1');
       // $form['5[]']->select('1');
       // $form['6[]']->select('1');
       // $form['7[]']->select('1');
       $crawler = $client->submit($form);

        //Log out
        $link = $crawler->filter('a:contains("Log out")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Overview
        $this->assertContains('Sign up', $crawler->filter('html')->text());

    }
}