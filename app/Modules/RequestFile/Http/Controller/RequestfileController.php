<?php

namespace Modules\RequestFile\Http\Controllers;

// use App\Entities\Configuration;
use Illuminate\Http\Request;
use Modules\RequestFile\Entities\Requestfile;

// use Modules\RequestFile\Http\Requests\RequestfileRequest;

class RequestfileController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Requestfile::fetch($request);
        return view('requestfile::default', compact('data'));
    }
}
