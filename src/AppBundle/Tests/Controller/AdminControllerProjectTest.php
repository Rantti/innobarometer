<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/9/2015
 * Time: 9:29 AM
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerProjectTest extends WebTestCase
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
        $link = $crawler->filter('a:contains("Projects")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that page loads.
        $this->assertContains('Project Administration', $crawler->filter('h1')->text());

        //click the link and go to create new Project
        $link = $crawler->filter('a:contains("New Project")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that page loads.
        $this->assertContains('New Project', $crawler->filter('h1')->text());

        // Save Team with user Adminpera2
        $form = $crawler->filter('form')->form();
        $form['app_project[project]'] = 'TestProject1';
        $form['app_project[startDate][year]']  = '2015';
        $form['app_project[startDate][month]'] = '1';
        $form['app_project[startDate][day]'] = '1';
        $form['app_project[endDate][year]']  = '2015';
        $form['app_project[endDate][month]'] = '1';
        $form['app_project[endDate][day]'] = '2';
        $form['app_project[teams][1]'] ->tick();
        $form['app_project[sprintRound]'] = '1';
        $crawler = $client->submit($form);

        //Test that the page contains the new project
        $this->assertContains('TestProject1', $crawler->filter('html')->text());

        // Removing Project and editing Project
        $link = $crawler->filter('a:contains("Remove TestProject1")')->eq(0)->link();
        $crawler = $client->click($link);

        $this->assertEquals(0, $crawler->filter('html:contains("TestProject1")')->count());

       // $results = $crawler->filterXPath('//td[text()="yrdst"]'); //'//tr[@td="yrdst"]'

        // This kind of works
       // $query = "//tr/td[.='yrdst']/following-sibling::td[2]";
        //var_dump($crawler->filterXPath($query)); // {
         //   var_dump($crawler->text());// . PHP_EOL;

        //Log out
        $link = $crawler->filter('a:contains("Log out")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Overview
        $this->assertContains('Sign up', $crawler->filter('html')->text());


    }


}
