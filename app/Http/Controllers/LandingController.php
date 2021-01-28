<?php

namespace App\Http\Controllers;

use App\Entities\UserLocal;
use Illuminate\Http\Request;
use Modules\Kelola\Entities\Banner;
use Illuminate\Support\Facades\Auth;
use Knp\Snappy\Pdf;
use Modules\FileType\Entities\FileArchive;
use Modules\FileType\Entities\FileType;
use Modules\Kelola\Entities\Konten;
use Modules\UnitKerja\Entities\UnitKerja;
use Validator;

class LandingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Banner::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $profil = Konten::orderBy('status', 'ASC')->get();
        return view('landing.index', compact('data','profil'));
    }


    public function detail($id)
    {
        $unitkerja = UnitKerja::where('kode', $id)->get();
        $fileType = FileType::where('unitkerja_kode', $id)->get();
        $data = FileArchive::join('app_filetype as ft', 'ft.id', 'app_filearchive.fileType')->where('ft.unitkerja_kode', $id)->get();
        return view('landing.detail', compact('data', 'unitkerja', 'fileType'));
    }

    public function login_iris()
    {
        return view('auth.login');
    }

    public function profil()
    {
        return view('landing.profil');
    }

    public function visi_misi()
    {
        return view('landing.visi_misi');
    }

    public function sekapur_sirih()
    {
        return view('landing.sekapur_sirih');
    }

    public function arsip_dokumen()
    {
        return view('landing.arsip_dokumen');
    }

    public function perencanaan_bisnis_bank()
    {
        return view('landing.perencanaan_bisnis_bank');
    }

    public function pengembangan_organisasi()
    {
        return view('landing.pengembangan_organisasi');
    }

    public function login()
    {
        return view('landing.login');
    }

    public function ceklogin(REQUEST $request)
    {
        $rules = [
            'username'              => 'required',
            'password'              => 'required|string'
        ];

        $messages = [
            'username.required'     => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'username'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        $a = UserLocal::attempt($data);
        dd($a);
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('landing');
        }
    }
}
