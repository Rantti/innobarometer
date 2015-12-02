<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/8/2015
 * Time: 4:41 PM
 */
// src/AppBundle/Tests/ApplicationAvailabilityFunctionalTest.php
namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('http://localhost:8000/login')
         //   array('/register'),
          //  array('/login'),
           // array('/questionnaire/1/edit'),
           // array('/questionnaire/1'),
          //  array('/questionnaire/questionnaire'),
          //  array('/statement/2/edit'),
          //  array('/statement/2/'),
          //  array('/statement/'),
          //  array('/teams'),
          //  array('/users'),
          //  array('/answer'),
           // array('/answer/form?id=1'),
           // array('/graphs'),
            // ...
        );
    }
}
?>