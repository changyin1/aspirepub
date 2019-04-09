<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Http\Requests\CreateScheduleRequest;
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index() {
        $schedules = Schedule::all();
        $clients = Client::all();
        $data = [
            'schedules' => $schedules,
            'clients' => $clients
        ];
        return view('admin.schedules', [
            'data' => $data
        ]);
    }

    public function create(CreateScheduleRequest $request) {

    }
}
