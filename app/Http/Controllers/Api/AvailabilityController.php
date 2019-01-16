<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvailabilityController extends Controller
{
    public function submit(Request $request) {
//        var_dump($request->all());
        return response()->json(['success' => false]);
    }
}
