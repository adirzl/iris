<?php

namespace Modules\Evaluasi\Providers;

class AppServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var string
     */
    protected $viewNamespace = 'evaluasi';

    /**
     * @return void
     */
    public function boot()
    {
        $this->registerViews();
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * @return void
     */
    public function registerViews()
    {
        $sourcePath = __DIR__ . '/../views';

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/' . $this->viewNamespace;
        }, \Config::get('view.paths')), [$sourcePath]), $this->viewNamespace);
    }
}
