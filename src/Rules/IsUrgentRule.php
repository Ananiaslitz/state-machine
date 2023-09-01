<?php

namespace Ananiaslitz\StateMachine\Rules;

class IsUrgentRule implements Rule
{
    private string $priority;

    public function __construct(string $priority)
    {
        $this->priority = $priority;
    }

    public function evaluate(array $context): bool
    {
        return $context['priority'] === $this->priority;
    }
}
