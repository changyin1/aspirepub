<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request){
        $data= [1,2,3];
        return view('availability.index', [
            'data' => $data
        ]);
    }
}
