<?php

namespace NaHelloWorld;

use InvalidArgumentException;

class Byte
{
    /**
     * @var string
     */
    private $byteString;

    /**
     * Byte constructor.
     * @param int $number
     */
    public function __construct($number = 0)
    {
        $this->setValue($number);
    }

    /**
     * @param integer $number
     * @return $this
     */
    public function setValue($number)
    {
        $this->byteString = decbin($number);

        if (strlen($this->byteString) > 8) {
            throw new InvalidArgumentException('Range should be between 0 and 255.');
        }

        while (strlen($this->byteString) < 8) {
            $this->byteString = "0" . $this->byteString;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getBinaryString()
    {
        return $this->byteString;
    }

    /**
     * @return string
     */
    public function getChar()
    {
        return chr(bindec($this->byteString));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getChar();
    }
}