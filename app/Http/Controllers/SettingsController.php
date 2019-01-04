<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class SettingsController extends Controller
{
    public function index(Request $request, Countries $countries){
        $states = $countries->where('cca3', 'USA')->first()->hydrateStates()->states->pluck('name', 'postal');
        $data= [1,2,3];
        return view('settings.index', [
            'data' => $data,
            'states' => $states
        ]);
    }
}
