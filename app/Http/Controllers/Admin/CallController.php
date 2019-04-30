<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use App\CallAssignment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallController extends Controller
{
    public function show($id) {
        $call = Call::where('id', $id)->first();
        $user = new User();
        $coaches = $user->hasRole('coach');
        $specialists = $user->hasRole('call_specialist');

        $data = [
            'call' => $call,
            'coaches' => $coaches,
            'specialists' => $specialists,
            'save' => false
        ];

        return view('admin.calls.edit', [
            'data' => $data
        ]);
    }

    public function assign(Request $request) {
        $call = Call::where('id', $request->id)->first();

        if ($call->completed_at) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'id' => ['This call has already been completed'],
            ]);
            throw $error;
        }

        CallAssignment::where('call_id', $request->id)->delete();

        foreach($request->specialists as $specialist_id) {
            $specialist = User::where('id', $specialist_id)->first();
            if (!$specialist || !$specialist->hasRole('call_specialist')) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'specialists' => ['You have selected an valid specialist'],
                ]);
                throw $error;
            }
            $callAssignment = new CallAssignment;
            $callAssignment->call_id = $request->id;
            $callAssignment->specialist_id = $specialist_id;

            $callAssignment->save();
        }

        return response()->json(['success' => true]);
    }
}
