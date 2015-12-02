<?php
/**
 * Created by PhpStorm.
 * User: Jyri
 * Date: 11/8/2015
 * Time: 7:43 PM
 */

 // src/AppBundle/Tests/Entity/ProductRepositoryFunctionalTest.php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryFunctionalTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function testSearchByUser()
    {
        $users = $this->em
            ->getRepository('AppBundle:User')
            ->findByUsername('pera')
        ;

        $this->assertCount(1, $users);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}