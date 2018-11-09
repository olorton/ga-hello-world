<?php

namespace NaHelloWorld;

class Population
{
    /* @var Individual[] */
    private $individuals = [];

    /* @var int */
    private $maxSize = 0;

    /* @var string */
    private $targetString;

    /**
     * Population constructor.
     */
    public function __construct($populationSize = 0, $targetString = '')
    {
        $this->maxSize = $populationSize;
        $this->targetString = $targetString;

        for ($p = 0; $p < $this->maxSize; $p++) {
            $this->individuals[] = new Individual(strlen($targetString));
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

    public function nextGeneration()
    {
        // Randomly mate
        $this->mate();

        // Mutate
        $randomness = 0; // Increase this to reduce mutation rate
        if (rand(0, $randomness) === 0 && count($this->individuals) > $this->maxSize) {
            // Only mutate a child
            $index = rand($this->maxSize, ($this->maxSize / 2) - 1);
            $this->mutate($index);
        }

        // Cull to max population size (weighted pool)
        $this->cull();

        echo "\n";
        $maxFitness = $this->individuals[0]->getMaxFitness();
        $a = $this->individuals[0];
        echo $a . ' --- ' .  $a->getGeneBinaryString() . ' --- ' . $a->getFitnessScore($this->targetString)  . ' / ' . $maxFitness;
        echo "\n";
        $b = $this->individuals[count($this->individuals) - 1];
        echo $b . ' --- ' .  $b->getGeneBinaryString() . ' --- ' . $b->getFitnessScore($this->targetString)  . ' / ' . $maxFitness;
        echo "\n";

        if ($a->getFitnessScore($this->targetString) == $maxFitness) {
            echo "Done\n";
            exit(1);
        }

        return $this;
    }

    public function mate()
    {
        $couples = $this->getCouples();
        $newPop = [];

        foreach($couples as $couple) {
            $children = $this->getChildren($couple);
            $newPop[] = new Individual(0, $children[0]->__toString());
            $newPop[] = new Individual(0, $children[1]->__toString());
        }

        $this->individuals = array_merge($this->individuals, $newPop);

        return $this;
    }

    public function mutate($index)
    {
        $original = $this->individuals[$index]->__toString();
        $this->individuals[$index] = $this->individuals[$index]->mutate();
        $this->individuals[] = new Individual(0, $original);

        return $this;
    }

    public function cull()
    {
        usort($this->individuals, function (Individual $a, Individual $b)
        {
            $aFitness = $a->getFitnessScore($this->targetString);
            $bFitness = $b->getFitnessScore($this->targetString);

            if ($aFitness == $bFitness) {
                return 0;
            }
            return ($aFitness < $bFitness) ? 1 : -1;
        });

        $this->individuals = array_slice($this->individuals, 0, $this->maxSize);

        return $this;
    }

    private function getCouples()
    {
        $pop = array_values($this->individuals);
        $couples = [];
        while (count($pop) >=2) {
            $index = rand(0, count($pop) - 1);
            $first = $pop[$index];
            unset($pop[$index]);
            $pop = array_values($pop);

            $index = rand(0, count($pop) - 1);
            $second = $pop[$index];
            unset($pop[$index]);
            $pop = array_values($pop);

            $couples[] = [$first, $second];
        }

        return $couples;
    }

    private function getChildren($couple)
    {
        $geneCount = $couple[0]->getGeneCount();
        $child1 = new Individual($geneCount);
        $child2 = new Individual($geneCount);

        /* @var Individual[] $couple */
        for ($i = 0; $i < count($geneCount); $i++) {
            if (rand(0, 1)) {
                // Swap gene
                $child1->setGene($i, $couple[1]->getGene($i));
                $child2->setGene($i, $couple[0]->getGene($i));
            } else {
                // No gene swap
                $child1->setGene($i, $couple[0]->getGene($i));
                $child2->setGene($i, $couple[1]->getGene($i));
            }
        }

        return [$child1, $child2];
    }
}
