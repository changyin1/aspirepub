<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CsvImportRequest;
use App\CsvData;
use App\Question;
use Auth;

class AdminController extends Controller
{
    public function index() {
    	$data['user'] = Auth::user();
    	return view('admin.index', [
            'data' => $data
        ]);
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
