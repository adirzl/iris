<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $files = app('files');

        foreach ($files->directories(app_path('Modules')) as $dir) {
            $basename = class_basename($dir);

            if (file_exists(app_path('Modules/' . $basename . '/Providers/AppServiceProvider.php'))) {
                $this->app->register('Modules\\' . $basename . '\\Providers\\AppServiceProvider');
            }

            if (file_exists(app_path('Modules/' . $basename . '/Providers/EventServiceProvider.php'))) {
                $this->app->register('Modules\\' . $basename . '\\Providers\\EventServiceProvider');
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
