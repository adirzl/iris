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

    public function approval($id){
        $data = Requestfile::findOrFail($id);
        return view('requestfile::approval', compact('data'));
    }

    public function storeapproval(Request $request, $requestfile){
        $data = Requestfile::findOrFail($requestfile);
        $data->status = $request->status == 1 ? 2 : 3;
        $data->rejectnote = isset($request->alasan_tolak) ? $request->alasan_tolak : null;

        $message = ['key' => 'Approval Request File', 'value' => $data->created_by];
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
            return redirect()->route('requestfile.create')->with($status, $response);
        }

        return redirect('requestfile')->with($status, $response);
    }
}
