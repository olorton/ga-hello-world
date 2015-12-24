<?php

use NaHelloWorld\Byte;

class ByteTest extends PHPUnit_Framework_TestCase
{
    public function testCanBeInstantiated()
    {
        $byte = new Byte();
    }
    public function testCanBeInstantiatedWithValue()
    {
        $byte = new Byte(5);
    }

    public function testCanGetBinaryString()
    {
        $byte = new Byte(65);

        $this->assertEquals('01000001', $byte->getBinaryString());
    }

    public function testCanSetValue()
    {
        $byte = new Byte();
        $byte->setValue(65);

        $this->assertEquals('01000001', $byte->getBinaryString());
    }

    public function testCanGetBinaryValueAsNumber()
    {
        $byte = new Byte(65);

        $this->assertEquals('A', $byte->getChar());
    }


    public function testToString()
    {
        $byte = new Byte(66);

        $this->assertEquals('B', $byte->getChar());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOnlyReturnMaximumEightBits()
    {
        // Would result in 10 characters: 1111101000
        $byte = new Byte(1000);
    }
}
