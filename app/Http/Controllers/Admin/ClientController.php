<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Client;
use App\Company;
use App\Region;
use App\Http\Requests\NewClientRequest;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::all();
        $categories = Category::all();
        $regions = Region::all();
        $companies = Company::all();

        $data = [
            'clients' => $clients,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies
        ];

        return view('admin.clients', [
            'data' => $data
        ]);
    }

    public function show($id) {
        $client = Client::where('id', $id)->first();
        $categories = Category::all();
        $regions = Region::all();
        $companies = Company::all();

        $data = [
            'client' => $client,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'save' => false
        ];

        return view('admin.clients.edit', [
            'data' => $data
        ]);
    }

    public function edit(NewClientRequest $request) {
        $client = Client::where('id', $request->id)->first();
        if (!$client) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'client' => ['That client does not exist.'],
            ]);
            throw $error;
        }

        if ($request->company && $request->company != 'null') {
            $company = Company::where('id', $request->company)->first();
            if (!$company) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'company' => ['Invalid company.'],
                ]);
                throw $error;
            }
        } else {
            $request->company = null;
        }

        if ($request-> category && $request->category != 'null') {
            $category = Category::where('id', $request->category)->first();
            if (!$category) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'category' => ['Invalid category.'],
                ]);
                throw $error;
            }
        } else {
            $request->category = null;
        }

        if ($request->region && $request->region != 'null') {
            $region = Region::where('id', $request->region)->first();
            if (!$region) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'region' => ['Invalid region.'],
                ]);
                throw $error;
            }
        } else {
            $request->region = null;
        }

        $client->name = $request->name;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->reservation_contact = $request->reservation_contact;
        $client->cancellation_email = $request->cancellation_email;
        $client->company_id = $request->company;
        $client->region_id = $request->region;
        $client->category_id = $request->category;

        $client->save();

        $categories = Category::all();
        $regions = Region::all();
        $companies = Company::all();

        $data = [
            'client' => $client,
            'categories' => $categories,
            'regions' => $regions,
            'companies' => $companies,
            'save' => false
        ];

        return view('admin.clients.edit', [
            'data' => $data
        ]);

    }

    public function create(NewClientRequest $request) {
        if ($request->company && $request->company != 'null') {
            $company = Company::where('id', $request->company)->first();
            if (!$company) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'company' => ['Invalid company.'],
                ]);
                throw $error;
            }
        } else {
            $request->company = null;
        }

        if ($request-> category && $request->category != 'null') {
            $category = Category::where('id', $request->category)->first();
            if (!$category) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'category' => ['Invalid category.'],
                ]);
                throw $error;
            }
        } else {
            $request->category = null;
        }

        if ($request->region && $request->region != 'null') {
            $region = Region::where('id', $request->region)->first();
            if (!$region) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'region' => ['Invalid region.'],
                ]);
                throw $error;
            }
        } else {
            $request->region = null;
        }

        $client = new Client;
        $client->name = $request->name;
        $client->city = $request->city;
        $client->country = $request->country;
        $client->reservation_contact = $request->reservation_contact;
        $client->cancellation_email = $request->cancellation_email;
        $client->company_id = $request->company;
        $client->region_id = $request->region;
        $client->category_id = $request->category;

        $client->save();
        return response()->json(['success' => true]);
    }
}
