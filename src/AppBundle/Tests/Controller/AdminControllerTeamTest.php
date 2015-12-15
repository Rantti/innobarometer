<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/9/2015
 * Time: 9:29 AM
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTeamTest extends WebTestCase
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

        //click the link and go to Teams
        $link = $crawler->filter('a:contains("Teams")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that page loads.
        $this->assertContains('Team Administration', $crawler->filter('h1')->text());

        //click the link and go to create new Team
        $link = $crawler->filter('a:contains("New Team")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that page loads.
        $this->assertContains('New Team', $crawler->filter('h1')->text());

        // Save Team with user Adminpera2
        $form = $crawler->filter('form')->form();
        $form['app_team[teamName]'] = 'TestTeam3';
        $form['app_team[country]']  = 'FIN';
        $form['app_team[users][1]'] ->tick();
        $crawler = $client->submit($form);

        //Test that the page contains the new Team
        $this->assertContains('TestTeam3', $crawler->filter('html')->text());

        // Removing team and editing team

        $link = $crawler->filter('a:contains("Remove TestTeam3")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test to see that there are no such teams
        $this->assertEquals(0, $crawler->filter('html:contains("TestTeam3")')->count());
        //Log out
        $link = $crawler->filter('a:contains("Log out")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Overview
        $this->assertContains('Sign up', $crawler->filter('html')->text());


        // dump the variables to console
        //var_dump($client->getResponse()->getContent());
    }


}
