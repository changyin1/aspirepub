<?php

namespace App\Http\Controllers\Admin;

use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index() {
        $schedules = Schedule::all();
        $data = [
            'schedules' => $schedules
        ];
        return view('admin.schedule', [
            'data' => $data
        ]);
    }
}
