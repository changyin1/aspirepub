<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Availability;

class AvailabilityController extends Controller
{
    public function submit(Request $request) {
		//TODO check user id has permission
		$user_id = $request->input('userID');
    	$date = date('Y-m-d',strtotime($request->input('date')));    	
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
		$availability->save();
		
		if ($availability->available !== NULL) {
			return response()->json(['success' => true, 'available' => $availability->available, 'date' => $availability->date]);		
		} else {
			return response()->json(['success' => false]);	
		}
        
    }

    public function get(Request $request) {
        $user_id = $request->input('userID');
        $date = date('Y-m-d',strtotime($request->input('date')));
        $availability = Availability::where('user_id', $user_id)->where('date', $date)->first();
        if ($availability) {
            return response()->json(['success' => true, 'available' => $availability->available]);
        } else {
            return response()->json(['success' => true, 'available' => 0]);
        }
    }
}
