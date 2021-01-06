<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'artikel' => \Modules\Kelola\Entities\Artikel::count(),
            'penilaian' => \Modules\Kuisioner\Entities\Penilaian::where('status','=','1')->count(),
            'laporan' => \Modules\Kelola\Entities\Laporan::where('status','=','1')->count(),
        ];
        // dd($data);exit();

        return view('home', compact('data'));
    }
}
