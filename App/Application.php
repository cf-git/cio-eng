<?php


namespace CFGit\CIO;


use CFGit\CIO\Service\ConsoleApplicationService;
use CFGit\CIO\Service\WebApplicationService;
use Illuminate\Container\Container;
use Illuminate\Support\Traits\Macroable;

class Application extends Container
{
    use Macroable;

    protected $basePath;
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function resources($path = "")
    {
        return $this->basePath.DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR.$path;
    }

    public function public($path = "")
    {
        return $this->basePath.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR.$path;
    }

    public function __construct($basePath)
    {
        $this->setBasePath($basePath);

        $this->bind('application.web', function () {
            return new WebApplicationService($this);
        });
        $this->bind('application.console', function () {
            return new ConsoleApplicationService($this);
        });
    }
}