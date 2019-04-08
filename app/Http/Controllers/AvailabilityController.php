<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use Auth;

class AvailabilityController extends Controller
{
	public function __construct()
	{
    	//$this->middleware('auth');
	}

    public function index(Request $request){
        $user = Auth::user();
        $data['user'] = $user;
        $data['items']= [1,2,3];
        $data['dates'] = Availability::where('user_id', $user->id)->where('available',1)->get();        
        return view('availability.index', [
            'data' => $data
        ]);
    }

    public function toggleAvailab(Request $request) {
    	//dd($request);
    	//TODO decide if proxy users or direct admin edit, can check if admin but need to make sure all admin can do.    	
    	$user = Auth::user();
    	$date = date('Y-m-d',strtotime($request->input('date')));
    	$available = $request->input('available');
    	$availability = Availability::firstOrCreate(
			['user_id' => $user->id], ['date' => $date]
		);
		$availability->available = $available;
		$availability->save();
    }

}
