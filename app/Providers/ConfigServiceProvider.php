<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ConfigServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(UrlGenerator $urlGenerator)
    {
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_configuration')) {
            Cache::forget('configurations');
            $configurations = Cache::has('configurations') ? Cache::get('configurations') :
                Cache::rememberForever('configurations', function () { return \App\Entities\Configuration::all(); });

            foreach ($configurations as $configuration) {
                $value = !in_array($configuration->value, ['true', 'false']) ? $configuration->value : $configuration->value === 'true';

                if ($configuration->component === 'database') {
                    $value = collect(json_decode($value, true))->mapWithKeys(function ($item) {
                        return [
                            $item['name'] => [
                                'driver' => $item['driver'], 'host' => $item['host'], 'port' => $item['port'],
                                'database' => $item['database'], 'username' => $item['username'], 'password' => $item['password'],
                                'charset' => ($item['driver'] === 'mysql' ? 'utf8mb4' : 'utf8'), 'prefix' => '',
                                'prefix_indexes' => true,
                            ]
                        ];
                    })->toArray();
                }

                Config::set($configuration->component . '.' . $configuration->key, $value);
            }

            if (request()->getHost() === config('app.domain_url')) {
                $urlGenerator->forceScheme('https');
                Config::set('app.url', config('app.domain_url'));
                Config::set('app.https', true);
            }

            if (request()->getHost() !== '127.0.0.1') {
                Config::set('session.domain', request()->getHost());
            }

            Config::set('app.debug', $this->app->environment() === 'production' ? true : false);
        }
    }
}
