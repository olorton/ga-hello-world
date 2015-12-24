<?php

use NaHelloWorld\Byte;
use NaHelloWorld\Individual;
use NaHelloWorld\Population;

class PopulationTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeInstantiated()
    {
        $pop = new Population();
    }

    public function testCanBeInstantiatedWith50Individuals()
    {
        $pop = new Population(50, 5);

        $this->assertEquals(50, $pop->getSize());
    }

    public function testCanGetIndividual()
    {
        $pop = new Population(50, 5);
        $individual = $pop->getIndividual(0);

        $this->assertTrue($individual instanceof Individual);
    }

    public function testSetGetIndividual()
    {
        $pop = new Population(50, 5);
        $individual = new Individual();
        $individual->setString('HELLO');

        $pop->setIndividual(25, $individual);
        $this->assertEquals('HELLO', $pop->getIndividual(25)->__toString());
    }

    public function testSetGetFittestIndividual()
    {
        $pop = new Population(50, 5);
        $individual = new Individual();
        $individual->setString('HELLO');

        $pop->setIndividual(25, $individual);
        $this->assertEquals('HELLO', $pop->getFittest('HELLO')->__toString());
    }
}
