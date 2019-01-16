<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Call;

class AgendaController extends Controller
{
    public function index(Request $request){
    	//$user = Auth::user();    	
        //$data['user'] = $user;
        //$data['calls'] = Call::where('user_id', $user->id);
        $data['items'] = [1,2,3];
        return view('agenda.index', [
            'data' => $data
        ]);
    }
}
