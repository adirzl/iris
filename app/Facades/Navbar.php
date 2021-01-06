<?php
/**
 * Created by PhpStorm.
 * User: I816
 * Date: 25/11/2019
 * Time: 18:14
 */

namespace App\Facades;

class Navbar extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'Navbar';
    }
}