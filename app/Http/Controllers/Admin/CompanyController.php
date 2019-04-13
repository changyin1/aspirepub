<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Requests\NewCompanyRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::all();
        $data = [
            'companies' => $companies
        ];
        return view('admin.companies', [
            'data' => $data
        ]);
    }

    public function create(NewCompanyRequest $request) {
        $company = new Company;
        $company->name = $request->name;

        $company->save();
        return response()->json(['success' => true]);
    }

    public function edit($id) {
        $company = Company::where('id', $id)->first();
        $data = [
            'company' => $company,
            'save' => false
        ];
        return view('admin.companies.edit', [
            'data' => $data
        ]);
    }

    public function update(NewCompanyRequest $request) {
        $company = Company::where('id', $request->id)->first();
        if (!$company) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'company' => ['That company does not exist.'],
            ]);
            throw $error;
        }

        $company->name = $request->name;
        $company->save();

        $data = [
            'company' => $company,
            'save' => true
        ];

        return view('admin.companies.edit', [
            'data' => $data
        ]);
    }
}
