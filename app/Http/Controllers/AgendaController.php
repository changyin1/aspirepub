<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Call;

class AgendaController extends Controller
{
    public function index(Request $request){
    	$user = Auth::user();
        $data['user'] = $user;
        $data['calls'] = Call::with('client', 'schedule')->get();
        //$data['items'] = [1,2,3];
        return view('agenda.index', [
            'data' => $data
        ]);
    }

    public function detail($id) {
        $user = Auth::user();
        $data['user'] = $user;
        $data['calls'] = Call::with('client', 'schedule')->find($id);
        //dd($data);
        return view('agenda.detail', [
            'data' => $data
        ]);
    }

    public function post(Request $request) {
        $user = Auth::user();
        $data['user'] = $user;
dd($request);
    }

}
