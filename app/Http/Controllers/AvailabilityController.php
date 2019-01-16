<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use Auth;

class AvailabilityController extends Controller
{
	public function __construct()
	{
    	$this->middleware('auth');
	}

    public function index(Request $request){
        $data= [1,2,3];
        return view('availability.index', [
            'data' => $data
        ]);
    }

    public function toggleAvailability($date, $available) {
    	//TODO decide if proxy users or direct admin edit, can check if admin but need to make sure all admin can do.    	
    	$user = Auth::user();
    	$date = date('Y-m-d',strtotime($date));		
    	$availability = Availability::firstOrCreate(
			['user_id' => $user->id], ['date' => $date]
		);
		$availability->available = $available;
		$availability->save();
    }
}
