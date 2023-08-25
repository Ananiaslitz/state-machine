<?php

namespace Ananiaslitz\StateMachine;

class StateMachine {
    private $currentState;
    private $transitions = [];

    public function __construct(State $initialState) {
        $this->currentState = $initialState;
    }

    public function addTransition(Transition $transition) {
        $this->transitions[] = $transition;
    }

    public function executeTransition(string $transitionName, array $context) {
        foreach ($this->transitions as $transition) {
            if ($transition->getName() === $transitionName && $transition->canExecute($this->currentState, $context)) {
                $this->currentState = $transition->getToState();
                return true;
            }
        }
        return false;
    }

    public function getCurrentState(): State {
        return $this->currentState;
    }
}
