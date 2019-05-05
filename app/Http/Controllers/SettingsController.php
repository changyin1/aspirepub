<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Countries\Package\Countries;

class SettingsController extends Controller
{
    public function index(Request $request, Countries $countries){
        $states = $countries->where('cca3', 'USA')->first()->hydrateStates()->states->pluck('name', 'postal');
        $user = Auth::user();
        $data= [
            'user' => $user
        ];
        return view('settings.index', [
            'data' => $data,
            'states' => $states
        ]);
    }

    public function save(Request $request, Countries $countries) {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->save();

        $states = $countries->where('cca3', 'USA')->first()->hydrateStates()->states->pluck('name', 'postal');
        $data= [
            'user' => $user
        ];
        return view('settings.index', [
            'data' => $data,
            'states' => $states
        ]);
    }
}
