<?php

namespace App\Http\Controllers;

use App\CallAssignment;
use App\CustomAgent;
use Carbon\Carbon;
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
        if ($user->role == 'coach') {
            $calls = Call::with('client', 'schedule')->where('coach', $user->id)->orderBy('due_date', 'asc')->get();
        } else {
            $calls = Call::with('client', 'schedule')->where('call_specialist', $user->id)->orWhere('coach', $user->id)->orderBy('due_date', 'asc')->get();
        }

        //get assigned calls
        $assigned = Call::join('call_assignments', function($join) use ($user) {
            $join->on('calls.id', '=', 'call_assignments.call_id')
                ->where('call_assignments.specialist_id', '=', $user->id);
        })->with('client', 'schedule')->get();

        $allCalls = $assigned->merge($calls);
        $data['calls'] = $allCalls->sortBy('due_date');

        return view('agenda.index', [
            'data' => $data
        ]);
    }

    public function detail($id) {
        $user = Auth::user();
        $data['user'] = $user;
        $data['call'] = Call::with('client', 'schedule')->find($id);

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
        $file = $request->file('file');
        $recordingFileName = 'call_' . $request->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        $s3 = \Storage::disk('s3');
        $filePath = '/recordings/' . $recordingFileName;
        $s3->put($filePath, file_get_contents($file), 'public');

        $recording = new Recording;
        $recording->call_id = $request->id;
        $recording->filename = $recordingFileName;
        $recording->path = 'https://s3-us-east-2.amazonaws.com/aspiremarketing/recordings/';
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

    public function completeCall(Request $request) {
        $user = Auth::user();
        $call = Call::findorfail($request->id);

        $agent = null;
        if ($request->agent) {
            $agent = CustomAgent::where('id', $request->agent)->first();
            if ($agent) {
                $agent->contacted = true;
                $agent->save();
            }
        }

        if ($request->link) {
            $recording = new Recording;
            $recording->call_id = $request->id;
            $recording->filename = $request->link;
            $recording->path = 'link';
            $recording->save();
        } elseif ($request->file('file')) {
            $file = $request->file('file');
            $recordingFileName = 'call_' . $request->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            $s3 = \Storage::disk('s3');
            $filePath = '/recordings/' . $recordingFileName;
            $s3->put($filePath, file_get_contents($file), 'public');

            $recording = new Recording;
            $recording->call_id = $request->id;
            $recording->filename = $recordingFileName;
            $recording->path = 'https://s3-us-east-2.amazonaws.com/aspiremarketing/recordings/';
            $recording->save();
        }

        $now = Carbon::now();
        $call->completed_at = $request->call_completed_at ? date_format(date_create($request->call_completed_at), 'Y-m-d H:i:s') : $now;
        $call->agent_name = $agent ? $agent->name : $request->call_receiver;
        $call->reservation_made = $request->reservation_made ? true : false;
        $call->arrival_date = date_format(date_create($request->reservation_start), 'Y-m-d');
        $call->departure_date = date_format(date_create($request->reservation_end), 'Y-m-d');
        $call->reservation_confirmation = $request->confirmation_number;
        $call->aspire_card_used = $request->card_used ? true : false;
        $call->save();

        return redirect('/schedule');
//        return response()->json(['success' => true]);
    }
}
