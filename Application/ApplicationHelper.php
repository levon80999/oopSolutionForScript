<?php

declare(strict_types = 1);

namespace App;

use Exception;

class ApplicationHelper
{
    /**
     * @var string
     */
    private string $config = __DIR__ . "/../config/options.ini";

    /**
     * @var Registry
     */
    private Registry $registry;

    public function __construct()
    {
        $this->registry = Registry::getInstance();
    }

    /**
     * @throws Exception
     */
    public function init(): void
    {
        $this->setupOptions();
    }

    /**
     * @throws Exception
     */
    private function setupOptions(): void
    {
        if (!file_exists($this->config)) {
            throw new Exception("Could not find options file");
        }

        $options = parse_ini_file($this->config, true);

        $this->registry->set('config', $options['config']);
    }
}
