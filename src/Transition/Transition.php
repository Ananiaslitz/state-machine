<?php

namespace Ananiaslitz\StateMachine;

use Ananiaslitz\StateMachine\Rules\Rule;

class Transition {
    private $name;
    private $fromState;
    private $toState;
    private $rule;

    public function __construct(string $name, State $fromState, State $toState, Rule $rule = null) {
        $this->name = $name;
        $this->fromState = $fromState;
        $this->toState = $toState;
        $this->rule = $rule;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getToState(): State {
        return $this->toState;
    }

    public function canExecute(State $currentState, array $context): bool {
        return $currentState->getName() === $this->fromState->getName() &&
            (is_null($this->rule) || $this->rule->evaluate($context));
    }
}
