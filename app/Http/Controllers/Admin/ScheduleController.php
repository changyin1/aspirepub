<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Http\Requests\CreateScheduleRequest;
use App\QuestionTemplate;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScheduleController extends Controller
{
    public function index() {
        $schedules = Schedule::all();
        $clients = Client::all();
        $templates = QuestionTemplate::all();
        $data = [
            'schedules' => $schedules,
            'clients' => $clients,
            'templates' => $templates
        ];
        return view('admin.schedules', [
            'data' => $data
        ]);
    }

    public function edit($id, Schedule $schedule) {
        $schedule = $schedule->where('id', $id)->first();

        if (!$schedule) {
            abort(404, 'The page you are looking for does not exist.');
        }

        $clients = Client::all();
        $templates = QuestionTemplate::all();

        $edit = !$schedule->start_date->isPast();

        $data = [
            'schedule' => $schedule,
            'clients' => $clients,
            'templates' => $templates,
            'edit' => $edit
        ];

        return view('admin.schedules.edit', [
            'data' => $data
        ]);
    }

    public function create(CreateScheduleRequest $request) {
        $startDate = Carbon::createFromFormat('d/m/Y', '01/'. $request->month .'/' . $request->year);
        $endDate = Carbon::createFromFormat('d/m/Y', '28/'. $request->month .'/' . $request->year);

        if ($startDate->isPast()) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'date' => ['Cannot make a schedule in the past'],
            ]);
            throw $error;
        }

        $schedule = new Schedule;
        $schedule->start_date = $startDate;
        $schedule->end_date = $endDate;
        $schedule->client_id = $request->client;
        $schedule->calls = $request->calls;
        $schedule->questionstemplates_id = $request->template;

        $schedule->save();
        return response()->json(['success' => true]);

    }

    public function modify(CreateScheduleRequest $request) {
        $request->validate([
            'schedule_id' => 'required'
        ]);
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        if (!$schedule) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'schedule_id' => ['Invalid Schedule'],
            ]);
            throw $error;
        }

        if ($schedule->start_date->isPast()) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'schedule_id' => ['Cannot edit a past schedule'],
            ]);
            throw $error;
        }

        $startDate = Carbon::createFromFormat('d/m/Y', '01/'. $request->month .'/' . $request->year);
        $endDate = Carbon::createFromFormat('d/m/Y', '28/'. $request->month .'/' . $request->year);

        if ($startDate->isPast()) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'date' => ['Cannot make a schedule in the past'],
            ]);
            throw $error;
        }

        $schedule->start_date = $startDate;
        $schedule->end_date = $endDate;
        $schedule->client_id = $request->client;
        $schedule->calls = $request->calls;
        $schedule->questionstemplates_id = $request->template;

        $schedule->save();
        return response()->json(['success' => true]);
    }
}
