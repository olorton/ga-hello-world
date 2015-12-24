<?php

namespace NaHelloWorld;

class Population
{
    /* @var Individual[] */
    private $individuals = [];

    /**
     * Population constructor.
     */
    public function __construct($populationSize = 0, $individualSize = 0)
    {
        for ($p = 0; $p < $populationSize; $p++) {
            $this->individuals[] = new Individual($individualSize);
        }
    }

    public function getSize()
    {
        return count($this->individuals);
    }

    public function getIndividual($position)
    {
        return $this->individuals[$position];
    }

    public function setIndividual($position, Individual $individual)
    {
        $this->individuals[$position] = $individual;

        return $this;
    }

    public function getFittest($targetString)
    {
        $fittest = null;
        $maxScore = 0;

        foreach ($this->individuals as $individual) {
            if ($individual->getFitnessScore($targetString) > $maxScore) {
                $fittest = $individual;
                $maxScore = $individual->getFitnessScore($targetString);
            }
        }

        return $fittest;
    }
}
