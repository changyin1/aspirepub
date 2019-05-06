<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use App\Client;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\DuplicateScheduleRequest;
use App\QuestionTemplate;
use App\Schedule;
use App\User;
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
        $calls = Call::where('schedule_id', $id)->get();

        $sortedCalls = [];

        if (!$calls->isEmpty()) {
            foreach($calls as $call) {
                $sortedCalls[$call->week()][] = $call;
            }
        }

        if (!$schedule) {
            abort(404, 'The page you are looking for does not exist.');
        }

        $clients = Client::all();
        $templates = QuestionTemplate::all();
        $user = new User();
        $coaches = $user->hasRole('coach');

        $edit = !$schedule->finalized;

        $data = [
            'schedule' => $schedule,
            'clients' => $clients,
            'templates' => $templates,
            'sortedCalls' => $sortedCalls,
            'edit' => $edit,
            'coaches' => $coaches,
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

    public function duplicate(DuplicateScheduleRequest $request) {
        $schedule = Schedule::findorfail($request->schedule_id);
        $startDate = Carbon::createFromFormat('d/m/Y', '01/'. $request->month .'/' . $request->year);
        $endDate = Carbon::createFromFormat('d/m/Y', '28/'. $request->month .'/' . $request->year);
        $schedule->duplicate($startDate, $endDate);
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

        if ($schedule->finalized) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'schedule_id' => ['Cannot edit a finalized schedule'],
            ]);
            throw $error;
        }

        $startDate = Carbon::createFromFormat('d/m/Y', '01/'. $request->month .'/' . $request->year);
        $endDate = Carbon::createFromFormat('d/m/Y', '28/'. $request->month .'/' . $request->year);

        if ($startDate->isPast()) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'date' => ['Cannot set a schedule in the past'],
            ]);
            throw $error;
        }

        $schedule->start_date = $startDate->toDateTimeString();
        $schedule->end_date = $endDate->toDateTimeString();
        $schedule->client_id = $request->client;
        $schedule->calls = $request->calls;
        $schedule->questionstemplates_id = $request->template;
        $schedule->finalized = $request->finalized;

        $schedule->save();

        if ($schedule->finalized) {
            try {
                $schedule->finalize();
            } catch (\Exception $e) {
                $schedule->finalized  = 0;
                $schedule->save();
                var_dump($e);
                return response()->json(['success' => false]);
            }

        }
        return response()->json(['success' => true]);
    }

    public function delete(Request $request) {
        $request->validate([
            'schedule_id' => 'required'
        ]);

        $schedule = Schedule::findorfail($request->schedule_id);

        if ($schedule->finalized) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'schedule_id' => ['Cannot delete a finalized schedule'],
            ]);
            throw $error;
        }

        $schedule->delete();
        return response()->json(['success' => true, 'redirect' => Route('admin/schedules')]);
    }

    public function addCalls(Request $request) {
        if (!in_array($request->week, [1, 2, 3, 4])) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'week' => ['Invalid week selected'],
            ]);
            throw $error;
        }
        if ($request->number <= 0) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'calls' => ['Must submit at least 1 call'],
            ]);
            throw $error;
        }
        $schedule = Schedule::findorfail($request->schedule_id);
        $schedule->addCalls($request->number, $request->week);
        return response()->json(['success' => true]);
    }
}
