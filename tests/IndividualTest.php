<?php

use NaHelloWorld\Byte;
use NaHelloWorld\Individual;

class IndividualTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeInstantiated()
    {
        $individual = new Individual(5);
    }

    public function testCanGetGeneBinaryString()
    {
        $individual = new Individual(5);

        $this->assertEquals(5*8, strlen($individual->getGeneBinaryString()));
    }

    public function testCanGetGene()
    {
        $individual = new Individual(5);

        /* @var $gene Byte */
        $gene = $individual->getGene(0);
        $this->assertTrue($gene instanceof Byte);
    }

    public function testCanSetGene()
    {
        $individual = new Individual(5);

        $individual->setGene(0, new Byte(0));
        $this->assertEquals('00000000', $individual->getGene(0)->getBinaryString());

        $individual->setGene(0, new Byte(255));
        $this->assertEquals('11111111', $individual->getGene(0)->getBinaryString());

        $individual->setGene(0, new Byte(85));
        $individual->setGene(1, new Byte(85));
        $individual->setGene(2, new Byte(85));
        $individual->setGene(3, new Byte(85));
        $individual->setGene(4, new Byte(85));
        $this->assertEquals('0101010101010101010101010101010101010101', $individual->getGeneBinaryString());
    }

    public function testGetMaxFitness()
    {
        $individual = new Individual(5);
        $this->assertEquals(5 * 8, $individual->getMaxFitness());

        $individual = new Individual(100);
        $this->assertEquals(100 * 8, $individual->getMaxFitness());
    }

    public function testGetFitnessScoreMinimum()
    {
        $individual = new Individual(5);
        // Set to a binary string of 0000000000000000000000000000000000000000
        $individual->setGene(0, new Byte(0));
        $individual->setGene(1, new Byte(0));
        $individual->setGene(2, new Byte(0));
        $individual->setGene(3, new Byte(0));
        $individual->setGene(4, new Byte(0));

        // 1111111111111111111111111111111111111111 as a binary string,
        // so it should be 0.
        $score = $individual->getFitnessScore(chr(255) . chr(255) . chr(255) . chr(255) . chr(255));

        $this->assertEquals(0, $score);
    }

    public function testGetFitnessScoreHalf()
    {
        $individual = new Individual(5);
        // Set to a binary string of 0000000000000000000000000000000000000000
        $individual->setGene(0, new Byte(0));
        $individual->setGene(1, new Byte(0));
        $individual->setGene(2, new Byte(0));
        $individual->setGene(3, new Byte(0));
        $individual->setGene(4, new Byte(0));

        // U = 85, which is 0101010101010101010101010101010101010101 as a binary string,
        // so the score should be half the max fitness.
        $score = $individual->getFitnessScore("UUUUU");

        $this->assertEquals($individual->getMaxFitness() / 2, $score);
    }

    public function testGetFitnessScoreMaximum()
    {
        $individual = new Individual(5);
        // Set to a binary string of 0000000000000000000000000000000000000000
        $individual->setGene(0, new Byte(0));
        $individual->setGene(1, new Byte(0));
        $individual->setGene(2, new Byte(0));
        $individual->setGene(3, new Byte(0));
        $individual->setGene(4, new Byte(0));

        // 0000000000000000000000000000000000000000 as a binary string,
        // so the score should be 40 (the max fitness).
        $score = $individual->getFitnessScore(chr(0) . chr(0) . chr(0) . chr(0) . chr(0));

        $this->assertEquals($individual->getMaxFitness(), $score);
    }

    public function testIsString()
    {
        $individual = new Individual(5);

        $this->assertEquals(5, strlen($individual));
    }

    public function testSetString()
    {
        $individual = new Individual();
        $individual->setString('HELLO WORLD');

        $this->assertEquals('HELLO WORLD', $individual->__toString());
    }

    public function testToString()
    {
        $individual = new Individual();
        $individual->setString('Jurgen Smurgen');

        $this->assertEquals('Jurgen Smurgen', $individual->__toString());
    }

    public function testMutation()
    {
        $individual = new Individual();
        $individual->setString('Jurgen Smurgen');
        $individual->mutate();

        $this->assertNotEquals('Jurgen Smurgen', $individual->__toString());
    }
}
