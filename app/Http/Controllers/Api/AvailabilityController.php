<?php

namespace App\Http\Controllers\Api;

use App\Call;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Availability;

class AvailabilityController extends Controller
{
    public function submit(Request $request) {
		//TODO check user id has permission
        $user = Auth::user();
		$user_id = $user->id;

		// store date as due date of the week e.g. week 2 stored as the 14th
    	$date = date('Y-m-d',strtotime($request->input('date')));
    	$weekOfMonth = $this->weekOfMonth($request->input('date'));
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));
    	$date = date('Y-m-d',strtotime($y . '-' . $m . '-' . ($weekOfMonth * 7)));
    	$availability = Availability::where('user_id', $user_id)->where('date', $date)->first();
		if ($availability) {
			if($availability->available == 0) {
				$availability->available = 1;
			} else {
				$availability->available = 0;
			}			
		} else {
			$availability = new Availability;
			$availability->user_id = $user_id;
			$availability->date = $date;
			$availability->available = 1;
		}
        $availability->max_calls = $request->max;
		$availability->save();
		
		if ($availability->available !== NULL) {
			return response()->json(['success' => true, 'available' => $availability->available, 'date' => $availability->date, 'week' => $weekOfMonth, 'max' => $availability->max_calls]);
		} else {
			return response()->json(['success' => false]);	
		}
        
    }

    public function get(Request $request) {
        $user_id = $request->input('userID');
        $date = date('Y-m-d',strtotime($request->input('date')));
        $availability = Availability::where('user_id', $user_id)->where('date', $date)->first();
        if ($availability) {
            return response()->json(['success' => true, 'available' => $availability->available, 'week' => $request->input('week'), 'max' => $availability->max_calls]);
        } else {
            return response()->json(['success' => true, 'available' => 0, 'week' => $request->input('week')]);
        }
    }

    public function weekOfMonth($date) {
        // extract date parts
        list($y, $m, $d) = explode('-', date('Y-m-d', strtotime($date)));

        $w = ceil($d / 7);

        // now return
        return $w;
    }

    public function claimCall(Request $request) {
        if (!$request->id) {
            return response()->json(['success' => false]);
        }
        $call = Call::where('id', $request->id)->first();
        if ($call->claimed()) {
            return response()->json(['success' => false]);
        }
        $user = Auth::user();
        $call->call_specialist = $user->id;
        $call->save();
        return response()->json(['success' => true]);
    }
}
