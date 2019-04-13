<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewRegionRequest;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index() {
        $regions = Region::all();
        $data = [
            'regions' => $regions
        ];
        return view('admin.regions', [
            'data' => $data
        ]);
    }

    public function create(NewRegionRequest $request) {
        $region = new Region;
        $region->name = $request->name;

        $region->save();
        return response()->json(['success' => true]);
    }

    public function edit($id) {
        $region = Region::where('id', $id)->first();
        $data = [
            'region' => $region,
            'save' => false
        ];
        return view('admin.regions.edit', [
            'data' => $data
        ]);
    }
    
    public function update(NewRegionRequest $request) {
        $region = Region::where('id', $request->id)->first();
        if (!$region) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'region' => ['That region does not exist.'],
            ]);
            throw $error;
        }

        $region->name = $request->name;
        $region->save();

        $data = [
            'region' => $region,
            'save' => true
        ];

        return view('admin.regions.edit', [
            'data' => $data
        ]);
    }
}
