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
            'company' => $company
        ];
        return view('admin.companies.edit', [
            'data' => $data
        ]);
    }
}
