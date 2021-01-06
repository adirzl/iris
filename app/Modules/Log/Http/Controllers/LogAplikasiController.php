<?php

namespace Modules\Log\Http\Controllers;

class LogAplikasiController extends \Rap2hpoutre\LaravelLogViewer\LogViewerController
{
    /**
     * LogAplikasiController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(['role:SUPER ADMIN']);
    }
}