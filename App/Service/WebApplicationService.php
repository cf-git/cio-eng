<?php


namespace CFGit\CIO\Service;

use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\FileEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\FileViewFinder;

class WebApplicationService
{
    protected $app;

    public function __construct(Container $container) {
        $this->boot();
        $this->app = $container;
    }

    public function boot()
    {
//        $this->app->bind('router', function() {
//        });
    }

    public function bootViews()
    {
        $this->app->singleton('files', function () {
            return new Filesystem;
        });

        $this->app->bind('view.finder', function ($app) {
            return new FileViewFinder($app['files'], $app['config']['view.paths']);
        });

        $this->app->bind('view.engine.file.resolver', function() {
            return new FileEngine;
        });
        $this->app->bind('view.engine.php.resolver', function() {
            return new PhpEngine;
        });
        $this->app->bind('view.engine.blade.resolver', function() {
            return new CompilerEngine($this->app->get('blade.compiler'));
        });

        $this->app->singleton('blade.compiler', function ($app) {
            return new BladeCompiler($app['files'], $app['config']['view.cache']);
        });

        $this->app->singleton('view.engine.resolver', function () {
            $resolver = new EngineResolver;

            // Next, we will register the various view engines with the resolver so that the
            // environment will resolve the engines needed for various views based on the
            // extension of view file. We call a method for each of the view's engines.
            foreach ([
                'file',
                'php',
                'blade'
            ] as $engine) {
                $resolver->register($engine, $this->app->make('view.engine.'.$engine.'.resolver'));
            }

            return $resolver;
        });

        $this->app->singleton('view.finder', function() {

        });

        $this->app->bind('view', function() {
            $resolver = $this->app['view.engine.resolver'];

            $finder = $this->app['view.finder'];
        });
    }

    public function load() {

    }
}