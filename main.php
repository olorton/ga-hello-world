<?php

require_once __DIR__ . '/bootstrap.php';

use NaHelloWorld\Population;

$pop = new Population(10, 'Hello World');
while (true) {
    $pop->nextGeneration();
}

