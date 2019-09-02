<?php

namespace App\Http\Controllers\Admin;

use App\Availability;
use App\Call;
use App\CallAssignment;
use App\CallType;
use App\CustomAgent;
use App\Http\Controllers\AvailabilityController;
use App\Language;
use App\User;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallController extends Controller
{
    public function show($id) {
        $call = Call::findorfail($id);
        $user = new User();
        $coaches = $user->hasRole('coach');
        $assignedIds = CallAssignment::where('call_id', $id)->get();
        $assigned = [];
        foreach($assignedIds as $assignId) {
            $assigned[] = User::where('id', $assignId->specialist_id)->first();
        }

        $agents = CustomAgent::where('schedule', $call->schedule->id)->get();

        $data = [
            'call' => $call,
            'coaches' => $coaches,
            'assigned' => $assigned,
            'agents' => $agents,
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

        $call->coach = $request->coach;
        $call->custom_agent_id = $request->agent;
        $call->save();

        CallAssignment::where('call_id', $request->id)->delete();

        if ($request->specialists) {
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
        }

        return response()->json(['success' => true]);
    }

    public function multiAssign(Request $request) {
        $types = ['coach', 'specialist', 'agent'];
        if (!in_array($request->type, $types)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'type' => ['You cannot assign calls to that user type'],
            ]);
            throw $error;
        }
        if (!$request->calls) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'calls' => ['No calls selected'],
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

        if ($request->type == 'agent') {
            foreach($call_ids as $call_id) {
                try {
                    $call = Call::where('id', $call_id)->first();
                    $call->custom_agent_id = $request->agent;
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
                            //check if call specialist is available
                            $call = Call::where('id', $call_id)->first();
                            $date = $call->assignmentDate();
                            $available = Availability::where('available', 1)->where('user_id', $specialist_id)->where('date', $date)->first();

                            if ($available) {
                                $callAssignment = new CallAssignment;
                                $callAssignment->call_id = $call_id;
                                $callAssignment->specialist_id = $specialist_id;

                                $callAssignment->save();
                            }
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
        if(!in_array($request->week, [0, 1, 2, 3, 4])) {
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

        if ($request->week == 0) {
            $dates = [];
            for ($i = 1; $i <= 4; $i++) {
                $scheduleDay = $i * 7 - 6;
                $dates[] = $scheduleYearMonth . '-' . sprintf('%02d', $scheduleDay);
            }
            $available = Availability::where('available', 1)->whereIn('date', $dates)->get();
        } else {
            $scheduleDay = $request->week * 7 - 6;

            $date = $scheduleYearMonth . '-' . sprintf('%02d', $scheduleDay);

            $available = Availability::where('available', 1)->where('date', '=', $date)->get();
        }

        if ($available->isEmpty()) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $results = [];
        foreach ($available as $specialist) {
            $user = User::where('id', $specialist->user_id)->first();
            if (!in_array(['id' => $user->id, 'text' => $user->name], $results)) {
                $results[] = ['id' => $user->id, 'text' => $user->name];
            }
        }
        return response()->json(['success' => true, 'results' => $results]);
    }

    public function delete(Request $request) {
        $call = Call::findorfail($request->call_id);
        $call->delete();

        $assignments = CallAssignment::where('call_id', $request->call_id)->get();
        foreach ($assignments as $assignment) {
            $assignment->delete();
        }
        return response()->json(['success' => true]);
    }

    public function settings() {
        $types = CallType::all();
        $languages = Language::all();
        $data = [
            'types' => $types,
            'languages' => $languages
        ];
        return view('admin.calls.settings', [
            'data' => $data
        ]);
    }

    public function createCallType(Request $request) {
        if(!$request->type) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'type' => ['Type name is required'],
            ]);
            throw $error;
        }

        if(!$request->price) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'price' => ['Type price is required'],
            ]);
            throw $error;
        }

        $type = new CallType();
        $type->type = $request->type;
        $type->price = $request->price;
        $type->save();

        return response()->json(['success' => true]);
    }

    public function createLanguage(Request $request) {
        if ($request->language) {
            $language = new Language();
            $language->language = $request->language;
            $language->save();

        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'language' => ['Invalid Language'],
            ]);
            throw $error;
        }

        return response()->json(['success' => true]);
    }

    public function showLanguage($id) {
        $language = Language::findorfail($id);
        $data = [
            'language' => $language,
            'save' => false
        ];

        return view('admin.calls.language', [
            'data' => $data
        ]);
    }

    public function editLanguage(Request $request) {
        $language = Language::findorfail($request->id);
        if (!$request->language) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'language' => ['Invalid Language'],
            ]);
            throw $error;
        }

        $language->language = $request->language;
        $language->save();

        $data = [
            'language' => $language,
            'save' => true
        ];

        return view('admin.calls.language', [
            'data' => $data
        ]);
    }

    public function showCallType($id) {
        $type = CallType::findorfail($id);
        $data = [
            'type' => $type,
            'save' => false
        ];

        return view('admin.calls.type', [
            'data' => $data
        ]);
    }

    public function editCallType(Request $request) {
        $type = CallType::findorfail($request->id);
        if (!$request->price) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'price' => ['Price is required'],
            ]);
            throw $error;
        }

        $type->type = $request->type;
        $type->price = $request->price;
        $type->save();

        $data = [
            'type' => $type,
            'save' => true
        ];

        return view('admin.calls.type', [
            'data' => $data
        ]);
    }
}
