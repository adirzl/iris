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

use setasign\Fpdi\Fpdi;
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
        $values['user_id'] = auth()->user()->id;
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
        $unitkerja = UnitKerja::where('kode', $id)->first();
        // $fileType = FileType::where('unitkerja_kode', $id)->get();
        // $data = FileArchive::join('app_filetype as ft', 'ft.id', 'app_filearchive.fileType_id')->where('ft.unitkerja_kode', $id)->get();
        $fileArchive = FileArchive::where('unitkerja_kode', $unitkerja->kode)
            // ->where('tipe_dokumen', 2)
            ->where('status', 1)
            ->get();

        $fileType = FileType::where('unitkerja_kode', $unitkerja->kode)->get();

        \Assets::addJs('landing.js');
        return view('landing.detail', compact('fileArchive', 'unitkerja', 'fileType'));
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

    public function landingdownload($id)
    {
        $file=FileArchive::find($id);
        
        $destination =storage_path('app/public/dokumen/'. $file->unitkerja_kode . '/' . $file->filetype_id . '/' . $file->filename);

        $text = auth()->user()->username.' - '.auth()->user()->profile->nama;
        $my_img = imagecreate( 320, 80 );                             //width & height
        
        $background  = imagecolorallocate( $my_img, 200,   79,   83 );
        $text_colour = imagecolorallocate( $my_img, 200,   79,   83 );
        // $line_colour = imagecolorallocate( $my_img, 128, 255, 0 );
        // imagestring( $my_img, 5, 20, 20, $text, $text_colour );
        // imagesetthickness ( $my_img, 3 );
        // imageline( $my_img, 30, 45, 165, 45, $line_colour );
        
        imagecolortransparent($my_img, $background);
        imagestring($my_img, 5, 18, 18, $text, $text_colour);
        $my_img=imagerotate($my_img, 50, 0);
        
        header( "Content-type: image/png" );
        //Save image
        
        imagepng( $my_img,'custom.png');
        
        $pdf = new Fpdi();

        
        // set the source file
        $c=$pdf->setSourceFile($destination);

        for($x=1;$x<=$c;$x++)
        {
            // add a page
            $pdf->AddPage();
            // import page 1
            $tplId = $pdf->importPage($x);
            // use the imported page and place it at point 10,10 with a width of 100 mm
            $pdf->useTemplate($tplId, 0, 0, 200);
        
            $pdf->Image('custom.png', 15, 15, 180, 270, 'png');
        }


        
        $pdf->Output();            
        // return view('landing');
    }

}
