<?php

namespace Ananiaslitz\StateMachine\Rules;

interface Rule {
    public function evaluate(array $context): bool;
}
