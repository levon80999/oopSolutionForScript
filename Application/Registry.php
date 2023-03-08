<?php

declare(strict_types = 1);

namespace App;

use function is_null;

class Registry
{
    /**
     * @var Registry|null
     */
    private static ?Registry $instance = null;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var ApplicationHelper|null
     */
    private ?ApplicationHelper $applicationHelper = null;

    /**
     * Private __construct to avoid double instance
     */
    private function __construct(){}

    /*
     * Singleton for Registry pattern
     */
    public static function getInstance(): Registry
    {
        if (is_null(self::$instance)) {
            return self::$instance = new Registry();
        }
        return self::$instance;
    }

    /**
     * @return ApplicationHelper
     */
    public function getApplicationHelper(): ApplicationHelper
    {
        if (is_null($this->applicationHelper)) {
            $this->applicationHelper = new ApplicationHelper();
        }

        return $this->applicationHelper;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }
}
