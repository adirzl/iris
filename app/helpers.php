<?php

if (!function_exists('to_lower')) {
    /**
     * @param string $str
     * @return string
     */
    function to_lower(string $str)
    {
        return strtolower($str);
    }
}

if (!function_exists('to_upper')) {
    /**
     * @param string $str
     * @return string
     */
    function to_upper(string $str)
    {
        return strtoupper($str);
    }
}

if (!function_exists('to_dropdown')) {
    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $collections
     * @param string $key
     * @param string|array $value
     * @param bool $blank_option
     * @return array
     */
    function to_dropdown($collections, string $key = 'id', $value = 'name', bool $blank_option = true)
    {
        $options = [];

        if ($blank_option) {
            $options[''] = trans('label.choose_one');
        }

        if (!is_array($collections)) {
            foreach ($collections as $collection) {
                if (is_array($value)) {
                    $tempValue = [];

                    foreach ($value as $val) {
                        $tempValue[] = $collection->$val;
                    }

                    $options[$collection->$key] = implode(' - ', $tempValue);
                } else {
                    $options[$collection->$key] = $collection->$value;
                }
            }
        } else {
            foreach ($collections as $key => $value) {
                $options[$key] = $value;
            }
        }

        return $options;
    }
}

if (!function_exists('to_check_radio')) {
    /**
     * @param \Illuminate\Database\Eloquent\Collection|array $collections
     * @param string $key
     * @param string $value
     * @return array
     */
    function to_check_radio($collections, string $key = 'id', string $value = 'name')
    {
        $options = [];

        if (is_array($collections)) {
            $collections = collect($collections);
        }

        foreach ($collections as $collection) {
            $options[$collection->$key] = $collection->$value;
        }

        return $options;
    }
}

if (!function_exists('format_date')) {
    /**
     * @param string $date
     * @param string $format
     * @param string|null $locale
     * @return string
     * @throws Exception
     */
    function format_date(string $date, string $format = '%A, %e %B %Y', string $locale = null)
    {
        if (!is_null($date)) {
            $locale = !is_null($locale) ? $locale : config('app.locale');
            setlocale(LC_TIME, $locale);

            if ($date instanceof \Carbon\Carbon) {
                return $date->formatLocalized($format);
            }

            return (new \Carbon\Carbon($date))->formatLocalized($format);
        }

        return '-';
    }
}

if (!function_exists('option_values')) {
    /**
     * @param string $name
     * @param bool $as_dropdown
     * @return array|null
     */
    function option_values(string $name, bool $as_dropdown = false)
    {
        if (\Modules\Opsi\Entities\OptionGroup::count()) {
            $results = \Modules\Opsi\Entities\OptionGroup::where('name', $name)->first()->optionValues;

            return ($as_dropdown ? to_dropdown($results, 'key', 'value') : $results);
        }

        return null;
    }
}

if (!function_exists('map_root_uri')) {
    /**
     * @return array
     */
    function map_root_uri()
    {
        $uri = [];
        $excluded_uris = ['/', 'home', 'login', 'logout'];

        foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if ($route->getPrefix() !== 'api' && !in_array($route->uri(), $excluded_uris) && $route->methods()[0] === 'GET') {
                if ($route->getName()) {
                    list($r, $a) = explode('.', $route->getName());

                    if ($a === 'index')
                        $uri[] = $r;
                } else {
                    $uri[] = $route->uri();
                }
            }
        }

        return $uri;
    }
}

if (!function_exists('map_action_uri')) {
    /**
     * @param bool $with_controller
     * @return array
     */
    function map_action_uri(bool $with_controller = false)
    {
        $uri = [];
        $excluded_uris = ['/', 'home', 'login', 'logout'];

        foreach (\Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if (!in_array($route->getPrefix(), ['api', '_ignition']) && !in_array($route->uri(), $excluded_uris) && in_array($route->methods()[0], ['GET', 'DELETE'])) {
                if ($route->getName() && \Illuminate\Support\Str::contains($route->getName(), '.')) {
                    list($r, $a) = explode('.', $route->getName());

                    if ($a !== 'index') {
                        if ($with_controller) {
                            $uri[$r][] = $a . ' ' . $r;
                        } else {
                            $uri[] = $a . ' ' . $r;
                        }
                    }
                } else {
                    if ($with_controller) {
                        $uri[$route->getName()][] = $route->uri();
                    } else {
                        $uri[] = $route->uri();
                    }
                }
            }
        }

        return $uri;
    }
}

if (!function_exists('permitRolesByUri')) {
    /**
     * @param string $uri
     * @return string
     */
    function permitRolesByUri(string $uri): string
    {
        if (\Illuminate\Support\Facades\Schema::connection(config('database.default'))->hasTable('mst_role_has_module')) {
            $result = \Illuminate\Support\Facades\DB::table('mst_role_has_module')
                ->select('mst_role.name')
                ->join('mst_module', 'mst_role_has_module.module_id', '=', 'mst_module.id')
                ->join('mst_role', 'mst_role_has_module.role_id', '=', 'mst_role.id')
                ->where('mst_module.uri', $uri)
                ->get();

            return ($result ? $result->implode('name', '|') : '');
        }

        return '';
    }
}

if (!function_exists('forPermissions')) {
    /**
     * @return array
     */
    function forPermissions(): array
    {
        $actions = map_action_uri(true);
        $modules = \App\Entities\Module::permissions();
        $exceptPermissions = array_merge($modules->pluck('uri')->toArray(), ['', 'register', 'password', 'verification', 'profile']);
        $permissions = \Modules\HakAkses\Entities\Permission::all()->pluck('name')->toArray();

        foreach ($permissions as $permission) {
            list($action, $module) = explode(' ', $permission);

            if (isset($actions[$module]) && collect($actions[$module])->contains($permission) === false) {
                $actions[$module][] = $permission;
            }
        }

        return [
            'actions' => $actions, 'modules' => $modules,
            'permissions' => collect($actions)->only($modules->pluck('uri'))->toArray(),
            'additionals' => collect($actions)->except($exceptPermissions)
                ->flatten()
                ->toArray(),
        ];
    }
}

if (!function_exists('isHome')) {
    /**
     * @return string
     */
    function isHome()
    {
        $uri = request()->getUri();

        return \Illuminate\Support\Str::contains($uri, 'home') ||
        $uri === str_replace(request()->getScheme() . '::', '', config('app.url')) ? 'active' : '';
    }
}

if (!function_exists('monthName')) {
    /**
     * @param int $month
     * @param string $format
     * @param string|null $locale
     * @return string
     */
    function monthName(int $month, string $format = '%B', string $locale = null)
    {
        $locale = !is_null($locale) ? $locale : config('app.locale');
        setlocale(LC_TIME, $locale);

        return \Carbon\Carbon::create(null, $month)->formatLocalized($format);
    }
}

if (!function_exists('numberToRoman')) {
    /**
     * @param int $number
     * @return string
     */
    function numberToRoman(int $number)
    {
        return \Riskihajar\Terbilang\Facades\Terbilang::roman($number);
    }
}

if (!function_exists('terbilang')) {
    /**
     * @param int $number
     * @param string|null $prefix
     * @param string|null $suffix
     * @return mixed
     */
    function terbilang(int $number, string $prefix = null, string $suffix = null)
    {
        return \Illuminate\Support\Str::title(\Riskihajar\Terbilang\Facades\Terbilang::make($number, $prefix, $suffix));
    }
}
