<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 22/05/18
 * Time: 22:56
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{


    public function testSettingLength(){

        $dinosaur = new Dinosaur();

        $this->assertSame(0, $dinosaur->getLength());

        $dinosaur->setLength(9);

        $this->assertSame(9, $dinosaur->getLength());
    }


    public function testDinosaurHasNotShrunk()
    {
        $dinosaur = new Dinosaur();

        $dinosaur->setLength(15);

        $this->assertGreaterThan( 16, $dinosaur->getLength(), 'Did you put it in the washing machine?');
    }


//    public function testThatYourComputerWorks(){
//
//        $this->assertTrue(false);
//    }

}