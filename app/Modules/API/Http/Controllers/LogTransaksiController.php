<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\Entities\LogTransaksi;

class LogTransaksiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = LogTransaksi::fetch($request);

        return view('api::log-transaksi.default', compact('data'));
    }
}