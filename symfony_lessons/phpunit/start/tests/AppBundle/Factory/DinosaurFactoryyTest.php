<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 27/05/18
 * Time: 11:53
 */

namespace Tests\AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{

    /**
     * @var DinosaurFactory
     */
    private $factory;

    public function setUp(){

        $this->factory = new DinosaurFactory();
    }




    public function testItGrowsALargeVelociraptor()
    {

        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }


    public function testItGrowsATriceratops()
    {

    }

}