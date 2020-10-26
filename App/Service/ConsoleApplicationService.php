<?php


namespace CFGit\CIO\Service;


use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;

class ConsoleApplicationService
{
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    public function load() {

    }
}