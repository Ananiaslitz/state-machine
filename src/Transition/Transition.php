<?php

namespace Ananiaslitz\StateMachine\Transition;
use Ananiaslitz\StateMachine\Machine\State;

class Transition
{
    private string $name;
    private State $fromState;
    private State $toState;
    private array $rules;

    public function __construct(
        string $name,
        State  $fromState,
        State  $toState,
        array $rules = []
    ) {
        $this->name = $name;
        $this->fromState = $fromState;
        $this->toState = $toState;
        $this->rules = $rules;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getToState(): State
    {
        return $this->toState;
    }

    public function canExecute(State $currentState, array $context): bool
    {
        if ($currentState->getName() !== $this->fromState->getName()) {
            return false;
        }

        foreach ($this->rules as $rule) {
            if (!$rule->evaluate($context)) {
                return false;
            }
        }

        return true;
    }
}
