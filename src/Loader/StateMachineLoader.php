<?php

namespace Ananiaslitz\StateMachine;

use Symfony\Component\Yaml\Yaml;

class StateMachineLoader
{
    private string $defaultYamlPath;

    public function __construct() {
        $projectRoot = $_SERVER['DOCUMENT_ROOT'];
        $this->defaultYamlPath = $projectRoot . '/state-machine.yaml';
    }

    public function load(string $yamlPath = null): array {
        if (!$yamlPath) {
            $yamlPath = $this->defaultYamlPath;
        }

        if (!file_exists($yamlPath)) {
            throw new \Exception("YAML file not found at: {$yamlPath}");
        }

        return Yaml::parseFile($yamlPath);
    }

}