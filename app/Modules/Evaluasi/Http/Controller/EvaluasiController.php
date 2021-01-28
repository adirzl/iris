<?php

namespace Modules\Evaluasi\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Evaluasi\Entities\Evaluasi;

// use Modules\Evaluasi\Http\Requests\EvaluasiRequest;

class EvaluasiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Evaluasi::fetch($request);
        return view('evaluasi::default', compact('data'));
    }

    public function show($id){
        $data = Evaluasi::findOrFail($id);
        return view('evaluasi::show', compact('data'));
    }
}
