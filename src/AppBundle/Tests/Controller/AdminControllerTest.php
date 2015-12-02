<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/9/2015
 * Time: 9:29 AM
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
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
        $link = $crawler->filter('a:contains("Statements")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Statement overview
        $this->assertContains('Statement overview', $crawler->filter('h2')->text());

        //click the link and go to Create Statement
        $link = $crawler->filter('a:contains("Create statements")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text New Statement
        $this->assertContains('statement.statement_new', $crawler->filter('h1')->text());

        // Save statement
        $form = $crawler->filter('form')->form();
        $crawler = $client->submit($form, array('app_statement[statement]' => 'asd', 'app_statement[category]' => 'Communications'));

        //Test that the page contains text statement asd
        $this->assertContains('asd', $crawler->filter('html')->text());

            // edit Statement should go here

            // $message = $crawler->filterXPath('td')->text();
            // $message = $crawler->extract(array('_text', 'td'));

            //var_dump($message);

            // $link = $crawler->filter('a:contains("Create statements")')->eq(0)->link();
            // $crawler = $client->click($link);

            // var_dump($client->getResponse()->getContent());
            // submit the form, need to put a couple assertation here



       //  Go to Questionnaires, SECOND LINK with the title Questionnaires.
        $link = $crawler->filter('a:contains("Questionnaires")')->eq(1)->link();
        $crawler = $client->click($link);
        //var_dump($client->getResponse()->getContent());

        //Test that the page contains text Questionnaire overview
        $this->assertContains('Questionnaire overview', $crawler->filter('h2')->text());

        //Go to Create Questionnaires
        $link = $crawler->filter('a:contains("Create questionnaires")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text questionnaire.questionnaire_post_new
        $this->assertContains('questionnaire.questionnaire_post_new', $crawler->filter('h1')->text());

        // Save Questionnaire (has to have at least 5 statements
        $form = $crawler->filter('form')->form();
        $form['app_questionnaire[sprintRound]'] = '1';
        $form['app_questionnaire[statements][0]'] ->tick();
        $form['app_questionnaire[statements][1]'] ->tick();
        $form['app_questionnaire[statements][2]'] ->tick();
        $form['app_questionnaire[statements][3]'] ->tick();
        $form['app_questionnaire[statements][4]'] ->tick();
        $form['app_questionnaire[extraRound]'] = '1';
        $crawler = $client->submit($form);


        //Test that the page contains text
        $this->assertContains('Questionnaire overview', $crawler->filter('h2')->text());


        //Log out
        $link = $crawler->filter('a:contains("Log out")')->eq(0)->link();
        $crawler = $client->click($link);

        //Test that the page contains text Overview
         $this->assertContains('Sign up', $crawler->filter('html')->text());


        // dump the variables to console
        //var_dump($client->getResponse()->getContent());
    }


}
