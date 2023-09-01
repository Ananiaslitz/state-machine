<?php

namespace Ananiaslitz\Examples\Rules;

use Ananiaslitz\StateMachine\Rules\Rule;

class IsPositiveRule implements Rule
{
    public function evaluate(array $context): bool
    {
        return isset($context['number']) && $context['number'] > 0;
    }
}