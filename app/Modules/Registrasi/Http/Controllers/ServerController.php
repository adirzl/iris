<?php
namespace Modules\Registrasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Knp\Snappy\Pdf;
use Modules\Registrasi\Entities\Server;
use Modules\Registrasi\Http\Requests\ServerRequest;

class ServerController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Server::fetch($request);

        return view('registrasi::server.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $registrasi_server = new Server;

        return view('registrasi::server.form', compact('registrasi_server'));
    }

    /**
     * @param ServerRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ServerRequest $request)
    {
        $registrasi_server = new Server;
        $values = $request->except(['_token', 'save']);
        $message = ['key' => 'Register Server', 'value' => $values['nama']];
        $status = 'error';
        $response = trans('message.create_failed', $message);
        $url = 'http://' . ($values['koneksi'] === 'development' ? config('parameter.uim_api_dev') : config('parameter.uim_api_prod'));
        $res = Http::post($url . '/authenticate', ['username' => config('parameter.uim_api_user'), 'password' => config('parameter.uim_api_pass')]);

        if ($res->ok()) {
            $token = json_decode($res->body(), true)['token'];
            $res = Http::withToken($token)->post($url . '/server', [
                'ip' => $values['ip_address'],
                'name' => $values['nama'],
                'env' => ($values['environment'] === 'development' ? 0 : 9),
                'blacklist' => $values['blacklist'],
            ]);

            if ($res->status() == 201) {
                $registrasi_server->hash_key = json_decode($res->body(), true)['data']['hash_key'];

                foreach ($values as $key => $value) {
                    $registrasi_server->$key = $value;
                }

                if ($registrasi_server->save()) {
                    $status = 'success';
                    $response = trans('message.create_success', $message);
                }
            } else {
                $response = json_decode($res->body())->message;
            }
        } else {
            $response = json_decode($res->body())->message;
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('register-server.create')->with($status, $response);
        }

        return redirect('registrasi-server')->with($status, $response);
    }

    /**
     * @param Server $registrasi_server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Server $registrasi_server)
    {
        return view('registrasi::server.form', compact('registrasi_server'));
    }

    /**
     * @param ServerRequest $request
     * @param Server $registrasi_server
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ServerRequest $request, Server $registrasi_server)
    {
        $ip_address = $registrasi_server->ip_address;
        $values = $request->except(['_token', '_method']);
        $message = ['key' => 'Register Server', 'value' => $registrasi_server->nama];
        $status = 'error';
        $response = trans('message.update_failed', $message);
        $url = 'http://' . ($values['koneksi'] === 'development' ? config('parameter.uim_api_dev') : config('parameter.uim_api_prod'));
        $res = Http::post($url . '/authenticate', ['username' => config('parameter.uim_api_user'), 'password' => config('parameter.uim_api_pass')]);

        if ($res->ok()) {
            $token = json_decode($res->body(), true)['token'];
            $res = Http::withToken($token)->put($url . '/server/' . $ip_address . '/update', [
                'ip' => $values['ip_address'],
                'name' => $values['nama'],
                'env' => ($values['environment'] === 'development' ? 0 : 9),
                'blacklist' => $values['blacklist'],
            ]);

            if ($res->status() == 201) {
                foreach ($values as $key => $value) {
                    $registrasi_server->$key = $value;
                }

                if ($registrasi_server->save()) {
                    $status = 'success';
                    $response = trans('message.update_success', $message);
                }
            } else {
                $response = json_decode($res->body())->message;
            }
        } else {
            $response = json_decode($res->body())->message;
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('registrasi-server')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param Server $registrasi_server
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Server $registrasi_server)
    {
        $message = ['key' => 'Register Server', 'value' => $registrasi_server->nama];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        $url = 'http://' . ($registrasi_server->koneksi === 'development' ? config('parameter.uim_api_dev') : config('parameter.uim_api_prod'));
        $res = Http::post($url . '/authenticate', ['username' => config('parameter.uim_api_user'), 'password' => config('parameter.uim_api_pass')]);

        if ($res->ok()) {
            $token = json_decode($res->body(), true)['token'];
            $res = Http::withToken($token)->delete($url . '/server/' . $registrasi_server->ip_address . '/destroy');

            if ($res->status() == 204 && $registrasi_server->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
            } else {
                $response = json_decode($res->body())->message;
            }
        } else {
            $response = json_decode($res->body())->message;
        }

        return redirect('registrasi-server')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'SERVER_APLIKASI_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\Registrasi\Exports\ServerExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Server::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('registrasi::server.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}