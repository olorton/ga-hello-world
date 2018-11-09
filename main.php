<?php

require_once __DIR__ . '/bootstrap.php';

use NaHelloWorld\Population;

$popSize = 10;
$targetString = 'Hello World';
$pop = new Population($popSize, $targetString);
while (true) {
    $pop->nextGeneration();
}

