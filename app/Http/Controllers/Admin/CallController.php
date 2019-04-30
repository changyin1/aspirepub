<?php

namespace App\Http\Controllers\Admin;

use App\Availability;
use App\Call;
use App\CallAssignment;
use App\Http\Controllers\AvailabilityController;
use App\User;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallController extends Controller
{
    public function show($id) {
        $call = Call::where('id', $id)->first();
        $user = new User();
        $coaches = $user->hasRole('coach');

        $data = [
            'call' => $call,
            'coaches' => $coaches,
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
                    'specialists' => ['You have selected an invalid user'],
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

    public function multiAssign(Request $request) {
        $types = ['coach', 'specialist'];
        if (!in_array($request->type, $types)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'type' => ['You cannot assign calls to that user type'],
            ]);
            throw $error;
        }

        $call_ids = explode(',', $request->calls);
        if ($request->type == 'coach') {
            foreach($call_ids as $call_id) {
                try {
                    $call = Call::where('id', $call_id)->first();
                    $call->coach = $request->coach;
                    $call->save();
                } catch (Exception $e) {
                    // do something if one failed?
                }
            }
        }

        if ($request->type == 'specialist') {
            foreach($call_ids as $call_id) {
                try {
                    CallAssignment::where('call_id', $call_id)->delete();

                    if ($request->specialists) {
                        foreach($request->specialists as $specialist_id) {
                            $callAssignment = new CallAssignment;
                            $callAssignment->call_id = $call_id;
                            $callAssignment->specialist_id = $specialist_id;

                            $callAssignment->save();
                        }
                    }

                } catch (Exception $e) {
                    // do something if one failed?
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function getAvailable(Request $request) {
        if(!in_array($request->week, [1, 2, 3, 4])) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'week' => ['Invalid Week'],
            ]);
            throw $error;
        }
        $schedule = Schedule::where('id', $request->schedule)->first();

        if (!$schedule) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'schedule' => ['You have selected an invalid schedule'],
            ]);
            throw $error;
        }

        $scheduleYearMonth = substr($schedule->start_date, 0,7);
        $scheduleDay = $request->week * 7 - 6;

        $date = $scheduleYearMonth . '-' . sprintf('%02d', $scheduleDay);

        $available = Availability::where('available', 1)->where('date', '=', $date)->get();

        if ($available->isEmpty()) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $results = [];
        foreach ($available as $key => $specialist) {
            $user = User::where('id', $specialist->user_id)->first();
            $results[$key] = ['id' => $user->id, 'text' => $user->name];
        }
        return response()->json(['success' => true, 'results' => $results]);
    }
}
