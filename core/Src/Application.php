<?php

namespace Src;

use Error;

class Application
{
    private Settings $settings;
    private Route $route;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function __get($key)
    {
            return $this->settings;
        }
        throw new Error('Accessing a non-existent property');
    }

    public function run(): void
    {
        $this->route->start();
    }
}