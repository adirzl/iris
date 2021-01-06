<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;

class OptionServiceProvider extends \Illuminate\Support\ServiceProvider
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
    public function boot()
    {
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_option_group')) {
            $tmp = [];
            Cache::forget('options');
            $results = Cache::has('options') ?
                Cache::get('options') :
                Cache::rememberForever('options', function () { return \Modules\Opsi\Entities\OptionGroup::all(); });

            if ($results) {
                foreach ($results as $result) {
                    $tmp[$result->name] = $result->optionValues
                        ->mapWithKeys(function ($item, $key) { return [$item['key'] => $item['value']]; })
                        ->toArray();
                }

                foreach ($tmp as $key => $value) {
                    \Illuminate\Support\Facades\View::share($key, $value);
                    \Illuminate\Support\Facades\Config::set('options.' . $key, $value);
                }
            }
        }
    }
}
