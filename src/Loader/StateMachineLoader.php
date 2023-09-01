<?php

namespace Ananiaslitz\StateMachine\Loader;

use Ananiaslitz\StateMachine\Machine\State;
use Ananiaslitz\StateMachine\Machine\StateMachine;
use Ananiaslitz\StateMachine\Transition\Transition;
use Symfony\Component\Yaml\Yaml;

class StateMachineLoader
{
    private string $defaultYamlPath;

    public function __construct() {
        $projectRoot = $_SERVER['DOCUMENT_ROOT'];
        $this->defaultYamlPath = $projectRoot . '/state-machine.yaml';
    }

    public function load(string $yamlPath = null): array {
        $yamlPath = $yamlPath ?? $this->defaultYamlPath;
        if (!file_exists($yamlPath)) {
            throw new \Exception("YAML file not found at: {$yamlPath}");
        }

        return Yaml::parseFile($yamlPath);
    }

    /**
     * @throws \Exception
     */
    public function createStateMachines(string $yamlPath = null): array {
        $config = $this->load($yamlPath);

        if (!isset($config['workflows'])) {
            throw new \Exception('Invalid YAML configuration');
        }

        $stateMachines = [];

        foreach ($config['workflows'] as $workflowName => $workflowConfig) {
            if (!isset($workflowConfig['initialState']) || !isset($workflowConfig['transitions'])) {
                throw new \Exception("Invalid configuration for workflow: {$workflowName}");
            }

            $initialState = new State($workflowConfig['initialState']);
            $stateMachine = new StateMachine($initialState);

            foreach ($workflowConfig['transitions'] as $transitionData) {
                $fromState = new State($transitionData['from']);
                $toState = new State($transitionData['to']);

                $ruleClasses = $transitionData['rules'] ?? [];
                $rules = [];
                foreach ($ruleClasses as $ruleClass) {
                    if (class_exists($ruleClass)) {
                        $rules[] = new $ruleClass();
                    } else {
                        throw new \Exception("Rule class {$ruleClass} does not exist");
                    }
                }

                $transition = new Transition(
                    $transitionData['name'],
                    $fromState,
                    $toState,
                    $rules
                );

                $stateMachine->addTransition($transition);
            }

            $stateMachines[$workflowName] = $stateMachine;
        }

        return $stateMachines;
    }
}