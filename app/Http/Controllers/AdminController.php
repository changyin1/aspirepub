<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CsvImportRequest;
use App\CsvData;
use App\Question;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
    	$data['user'] = Auth::user();
    	return view('admin.index', [
            'data' => $data
        ]);
    }

    public function users() {
        $data['users'] = User::all();
        return view('admin.users', [
            'data' => $data
        ]);
    }

    public function editUser($id) {
        $data['user'] = User::findorfail($id);
        $data['save'] = false;
        return view('admin.users.edit', [
            'data' => $data,
        ]);
    }

    public function updateUser($id, Request $request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'role' => ['required', 'string', Rule::in(['admin', 'coach', 'call_specialist'])]
        ]);

        if ($request->password) {
            $this->validate($request, [
                'password' => ['required', 'string', 'min:6'],
            ]);
        }
        $user = User::findorfail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request['password']);
        }
        $user->role = $request->role;
        $user->save();

        $data = [
            'user' => $user,
            'save' => true
        ];
        return view('admin.users.edit', [
            'data' => $data,
        ]);
    }

    public function deleteUser(Request $request) {
        $user = User::findorfail($request->user_id)->delete();
        return response()->json(['success' => true, 'redirect' => Route('admin/users')]);
    }

    public function uploadQuestions() {
    	$data['hw'] = 'HW';
    	return view('admin.upload-questions', [
            'data' => $data
        ]);
    }

    public function getImport()
    {
        return view('import');
    }

    public function parseImport(CsvImportRequest $request)
	{

	    $path = $request->file('csv_file')->getRealPath();

	    if ($request->has('header')) {
	        $data = Excel::load($path, function($reader) {})->get()->toArray();
	    } else {
	        $data = array_map('str_getcsv', file($path));
	    }

	    if (count($data) > 0) {
	        if ($request->has('header')) {
	            $csv_header_fields = [];
	            foreach ($data[0] as $key => $value) {
	                $csv_header_fields[] = $key;
	            }
	        }
	        $csv_data = array_slice($data, 0, 2);

	        $csv_data_file = CsvData::create([
	            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
	            'csv_header' => $request->has('header'),
	            'csv_data' => json_encode($data)
	        ]);
	    } else {
	        return redirect()->back();
	    }

	    return view('admin.import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

	}

	public function processImport(Request $request)
	{
	    $data = CsvData::find($request->csv_data_file_id);
	    $csv_data = json_decode($data->csv_data, true);
	    foreach ($csv_data as $row) {
	        $question = new Question();
	        foreach (config('app.db_fields') as $index => $field) {
	            if ($data->csv_header) {
	                $question->$field = $row[$request->fields[$field]];
	            } else {
	                $question->$field = $row[$request->fields[$index]];
	            }
	        }
	        $question->save();
	    }

	    return view('admin.import_success');
	}

	public function import() 
    {
        Excel::import(new UsersImport, 'users.xlsx');
        
        return redirect('/')->with('success', 'All good!');
    }
}
