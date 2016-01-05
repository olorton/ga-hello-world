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
        $pop = new Population(50, '12345');

        $this->assertEquals(50, $pop->getSize());
    }

    public function testCanGetIndividual()
    {
        $pop = new Population(50, '12345');
        $individual = $pop->getIndividual(0);

        $this->assertTrue($individual instanceof Individual);
    }

    public function testSetGetIndividual()
    {
        $pop = new Population(50, '12345');
        $individual = new Individual();
        $individual->setString('HELLO');

        $pop->setIndividual(25, $individual);
        $this->assertEquals('HELLO', $pop->getIndividual(25)->__toString());
    }

    public function testSetGetFittestIndividual()
    {
        $pop = new Population(50, '12345');
        $individual = new Individual();
        $individual->setString('HELLO');

        $pop->setIndividual(25, $individual);
        $this->assertEquals('HELLO', $pop->getFittest('HELLO')->__toString());
    }

    public function testNext()
    {
        $pop = new Population(5, '12345');
        $pop2 = clone $pop;

        $pop2->nextGeneration();
        $this->assertNotEquals($pop, $pop2, 'Populations have not changed');
    }

    public function testMate2()
    {
        $pop = new Population(2, '12345');
        $this->assertEquals(2, $pop->getSize());

        $pop->mate();
        $this->assertEquals(4, $pop->getSize());
    }

    public function testMate13()
    {
        $pop = new Population(13, '12345');
        $this->assertEquals(13, $pop->getSize());

        $pop->mate();
        $this->assertEquals(25, $pop->getSize());
    }

    public function testMutate()
    {
        $pop = new Population(1, '12345');
        $first = $pop->getIndividual(0)->getGeneBinaryString();
        $pop->mutate(0);
        $second = $pop->getIndividual(0)->getGeneBinaryString();

        $this->assertNotEquals($first, $second, 'Populations have not changed, no mutation taken place');
    }

    public function testCull()
    {
        $pop = new Population(5, '12345');
        $pop->mate();
        $pop->cull();

        $this->assertEquals(5, $pop->getSize());
    }
}
