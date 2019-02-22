<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Call;
use App\Recording;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AgendaController extends Controller
{
    public function index(Request $request){
    	$user = Auth::user();
        $data['user'] = $user;
        $data['calls'] = Call::with('client', 'schedule')->where('call_specialist', $user->id)->orWhere('coach', $user->id)->get();
        //$data['items'] = [1,2,3];
        return view('agenda.index', [
            'data' => $data
        ]);
    }

    public function detail($id) {
        $user = Auth::user();
        $data['user'] = $user;
        $data['calls'] = Call::with('client', 'schedule')->find($id);
        //dd($data);
        return view('agenda.detail', [
            'data' => $data
        ]);
    }

    public function post(Request $request) {
        $user = Auth::user();
        $data['user'] = $user;
        $call = Call::findOrFail($request->input('call_id'));
        $call->agent_name = $request->input('Contact');
        $call->completed_at = $request->input('calltime');
        $call->caller_notes = $request->input('caller_notes');

        if($request->file('recording') !== NULL) {
            $file = $request->file('recording');
            $recordingFileName = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();        

            $s3 = \Storage::disk('s3');
            $filePath = '/recordings/' . $recordingFileName;
            $s3->put($filePath, file_get_contents($file), 'public');
        }
        $call->save();
        return redirect('/schedule');
    }


    public function upload_selector() {        
        $data['user'] = 'steve';
        $data['recordings'] = Recording::all();
        return view('agenda.store', [
            'data' => $data
        ]);
    }

    public function store_file(Request $request) {
        //dd($request);
        $file = $request->file('recording');
        $recordingFileName = 'test_' . time() . '.' . $file->getClientOriginalExtension();        

        $s3 = \Storage::disk('s3');
        $filePath = '/recordings/' . $recordingFileName;
        $s3->put($filePath, file_get_contents($file), 'public');

        $recording = new Recording;
        $recording->call_id = 1;    
        $recording->filename = $recordingFileName;
        $recording->path = 'https://s3-us-west-2.amazonaws.com/aspiremarketing/recordings/';
        $recording->save();
        /*
        $my_file = 'test_import.csv';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $data = 'Test data to see if this works!';
        fwrite($handle, $data);

        $storagePath = Storage::disk('s3')->put("uploads", $my_file, 'public');
        */
        //$path = $request->file('avatar')->store('avatars');
        return redirect('/store');
    }

}
