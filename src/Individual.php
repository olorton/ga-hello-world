<?php

namespace NaHelloWorld;

class Individual
{
    /* @var Byte[] */
    private $genes = [];

    /**
     * Individual constructor.
     * @param int $charCount
     */
    public function __construct($charCount = 0)
    {
        for ($i = 0; $i < $charCount; $i++) {
            $this->genes[] = new Byte(rand(32,126));
        }
    }

    public function getGeneCount()
    {
        return count($this->genes);
    }

    /**
     * @param $position
     * @return Byte
     */
    public function getGene($position)
    {
        return $this->genes[$position];
    }

    /**
     * @param $position
     * @param Byte $gene
     * @return $this
     */
    public function setGene($position, Byte $gene)
    {
        $this->genes[$position] = $gene;

        return $this;
    }

    public function setString($string)
    {
        $result = [];
        foreach (str_split($string) as $char) {
            $result[] = new Byte(ord($char));
        }
        $this->genes = $result;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneBinaryString()
    {
        $binaryString = '';
        foreach ($this->genes as $gene) {
            /* @var $gene Byte */
            $binaryString .= $gene->getBinaryString();
        }

        return $binaryString;
    }

    /**
     * @return int
     */
    public function getMaxFitness()
    {
        return (count($this->genes) * 2) + (count($this->genes) * 8);
    }


    /**
     * @return string
     */
    public function __toString()
    {
        $result = '';
        foreach ($this->genes as $gene) {
            $result .= $gene->getChar();
        }

        return $result;
    }

    public function getFitnessScore($string)
    {
        return $this->getFitnessScoreBinary($string) + ($this->getFitnessScoreChars($string) * 2);
    }

    public function getFitnessScoreChars($target)
    {
        $current = str_split($this->__toString());
        $target = str_split($target);

        $score = 0;
        foreach ($target as $i => $char) {
            if ($char == $current[$i]) {
                $score++;
            }
        }

        return $score;
    }

    public function getFitnessScoreBinary($string)
    {
        $current = str_split($this->getGeneBinaryString());
        $target = [];
        foreach (str_split($string) as $char) {
            $gene = new Byte(ord($char));
            foreach (str_split($gene->getBinaryString()) as $bit) {
                $target[] = $bit;
            }
        }

        $score = 0;
        foreach ($target as $i => $bit) {
            if ($bit == $current[$i]) {
                $score++;
            }
        }

        return $score;
    }

    public function mutate()
    {
        $this->genes[rand(0,count($this->genes) - 1)]->mutate();

        return $this;
    }
}
