<?php

namespace App\Http\Controllers;

use App\Entities\UserLocal;
use Illuminate\Http\Request;
use Modules\Kelola\Entities\Banner;
use Illuminate\Support\Facades\Auth;
use Knp\Snappy\Pdf;
use Modules\Dokumen\Entities\FileArchive;
use Modules\Dokumen\Entities\FileType;
use Modules\Kelola\Entities\Konten;
use Modules\RequestFile\Entities\Requestfile;
use Modules\UnitKerja\Entities\UnitKerja;
use Modules\User\Entities\User;
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
        $fileArchive = FileArchive::where('unitkerja_kode', env('D_PERENCANAAN_ID'))
            // ->where('tipe_dokumen', 2)
            ->where('status', 1)
            ->get();

        $fileType = FileType::where('unitkerja_kode', env('D_PERENCANAAN_ID'))->get();

        \Assets::addJs('landing.js');
        return view('landing.index', compact('data', 'profil', 'fileArchive', 'fileType'));
    }

    public function landingrequestfile($id)
    {
        if (Auth::check()) {
            $data = FileArchive::findOrFail($id);
            return view('landing.requestfile', compact('data'));
        } else {
            return view('landing.login');
        }
    }

    public function storelandingrequestfile(Request $request)
    {
        $data = new Requestfile();
        $values = $request->except(['_token', 'save']);
        // $values['user_id'] = auth()->user()->id;
        $values['user_id'] = 'f88137f6-78ee-496d-984d-05e4b483743e';
        $values['status'] = 1;

        foreach ($values as $key => $value) {
            $data->$key = $value;
        }

        $message = ['key' => 'Request file', 'value' => $values['user_id']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($data->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('landing')->with($status, $response);
        }

        return redirect('landing')->with($status, $response);
    }


    public function detail($id)
    {
        $unitkerja = UnitKerja::where('kode', $id)->get();
        $fileType = FileType::where('unitkerja_kode', $id)->get();
        $data = FileArchive::join('app_filetype as ft', 'ft.id', 'app_filearchive.fileType_id')->where('ft.unitkerja_kode', $id)->get();
        return view('landing.detail', compact('data', 'unitkerja', 'fileType'));
    }

    public function login_i()
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
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('landing')->withErrors($validator)->withInput($request->all);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            if ($request->filearchive != null) {
                return redirect()->route('landingrequestfile', ['id' => $request->filearchive])->with(['success' => 'Login Berhasil']);
            } else {
                return redirect()->route('landing')->with(['success' => 'Login Berhasil']);
            }
        } else {
            return redirect()->route('landing')->with(['error' => 'Username atau Password anda salah !!']);
        }
    }
}
