<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Countries\Package\Countries;

class UtilitiesController extends Controller
{
    public function getCities(Request $request, Countries $countries) {
        $cities = $countries->where('cca3', 'USA')->first()->hydrateCities()->cities->where('adm1name', $request->get('state'))->pluck('name');
        $results = [];
        foreach ($cities as $key => $city) {
            if ($city) {
                $results[$key] = ['id' => $city, 'text' => $city];
            }
        }
        return response()->json(['results' => $results, 'pagination' => ['more' => false]]);
    }
}
