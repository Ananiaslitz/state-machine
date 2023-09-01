<?php

require 'vendor/autoload.php';

use Ananiaslitz\Examples\Rules\IsEvenRule;
use Ananiaslitz\Examples\Rules\IsPositiveRule;
use Ananiaslitz\StateMachine\Machine\State;
use Ananiaslitz\StateMachine\Machine\StateMachine;
use Ananiaslitz\StateMachine\Transition\Transition;

/**
 * Initialize states
 */
function initializeStates(): array
{
    $start = new State('start');
    $even = new State('even');
    $positive = new State('positive');
    $end = new State('end');

    return [$start, $even, $positive, $end];
}

/**
 * Initialize transitions
 */
function initializeTransitions($start, $even, $positive, $end): array
{
    $isEvenRule = new IsEvenRule();
    $isPositiveRule = new IsPositiveRule();

    $toEven = new Transition('toEven', $start, $even, [$isEvenRule]);
    $toPositive = new Transition('toPositive', $start, $positive, [$isPositiveRule]);
    $toEnd = new Transition('toEnd', $even, $end, [$isPositiveRule]);
    $toEndFromPositive = new Transition('toEndFromPositive', $positive, $end, [$isEvenRule]);

    return [$toEven, $toPositive, $toEnd, $toEndFromPositive];
}

[$start, $even, $positive, $end] = initializeStates();

[$toEven, $toPositive, $toEnd, $toEndFromPositive] = initializeTransitions($start, $even, $positive, $end);

$sm = new StateMachine($start);
$sm->addTransition($toEven);
$sm->addTransition($toPositive);
$sm->addTransition($toEnd);
$sm->addTransition($toEndFromPositive);

$context = ['number' => 4];

try {
    if ($sm->executeTransition('toEven', $context)) {
        echo "Transition toEven executed. Current State: " . $sm->getCurrentState()->getName() . PHP_EOL;
    }

    if ($sm->executeTransition('toEnd', $context)) {
        echo "Transition toEnd executed. Current State: " . $sm->getCurrentState()->getName() . PHP_EOL;
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
