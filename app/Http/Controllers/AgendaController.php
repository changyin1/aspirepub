<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request){
        $data= [1,2,3];
        return view('agenda.index', [
            'data' => $data
        ]);
    }
}
