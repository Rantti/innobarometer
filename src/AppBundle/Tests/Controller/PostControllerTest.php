<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/8/2015
 * Time: 10:03 PM
 */
 // src/AppBundle/Tests/Controller/PostControllerTest.php
namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Overview")')->count()
        );
    }
}