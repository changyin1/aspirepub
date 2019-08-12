<?php

namespace App\Http\Controllers\Admin;

use App\Call;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index() {
        $data = $this->quickStats();

        return view('admin.reports', [
            'data' => $data
        ]);
    }

    public function incomplete($date = null) {
        $titleAppend = '';
        $incomplete = Call::whereNull('completed_at');

        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        $thisWeekDay = $this->roundUpToAny($day, 7);
        $thisWeek = $year . '-' . $month . '-' . $thisWeekDay;
        $thisMonth = $year . '-' . $month . '-';

        if ($date == 'week') {
            $incomplete = $incomplete->where('due_date', $thisWeek);
            $titleAppend = 'This Week';
        }

        if ($date == 'month') {
            $incomplete = $incomplete->where(function ($q) use ($thisMonth) {
                $q->where('due_date', $thisMonth . '7')->orWhere('due_date', $thisMonth . '14')->orWhere('due_date', $thisMonth . '21')->orWhere('due_date', $thisMonth . '28');
            });
            $titleAppend = 'This Month';
        }

        $data['callList'] = $incomplete->get();
        $data['title'] = 'Calls To Be Completed ' . $titleAppend;
        $data['route'] = Route('admin/reports/incomplete');

        return view('admin.reports.report', [
            'data' => $data
        ]);
    }

    public function unscored($date = null) {
        $titleAppend = '';
        $unscored = Call::whereNull('scored_at')->WhereNotNull('completed_at');

        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        $thisWeekDay = $this->roundUpToAny($day, 7);
        $thisWeek = $year . '-' . $month . '-' . $thisWeekDay;
        $thisMonth = $year . '-' . $month . '-';

        if ($date == 'week') {
            $unscored = $unscored->where('due_date', $thisWeek);
            $titleAppend = 'This Week';
        }

        if ($date == 'month') {
            $unscored = $unscored->where(function ($q) use ($thisMonth) {
                $q->where('due_date', $thisMonth . '7')->orWhere('due_date', $thisMonth . '14')->orWhere('due_date', $thisMonth . '21')->orWhere('due_date', $thisMonth . '28');
            });
            $titleAppend = 'This Month';
        }

        $data['callList'] = $unscored->get();
        $data['title'] = 'Calls To Be Scored ' . $titleAppend;
        $data['route'] = Route('admin/reports/unscored');

        return view('admin.reports.report', [
            'data' => $data
        ]);
    }

    private function quickStats () {
        $calls = Call::all();

        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        $thisWeekDay = $this->roundUpToAny($day, 7);
        $thisWeek = $year . '-' . $month . '-' . $thisWeekDay;
        $thisMonth = $year . '-' . $month . '-';

        $calls = [
            'all' => $calls,
            'week' => Call::where('due_date', $thisWeek)->get(),
            'month' => Call::where('due_date', $thisMonth . '7')->orWhere('due_date', $thisMonth . '14')->orWhere('due_date', $thisMonth . '21')->orWhere('due_date', $thisMonth . '28')->get(),
        ];

        $toBeCompleted = [
            'all' => Call::whereNull('completed_at')->get(),
            'week' => Call::whereNull('completed_at')->where('due_date', $thisWeek)->get(),
            'month' => Call::whereNull('completed_at')->where('due_date', $thisMonth . '7')->orWhere('due_date', $thisMonth . '14')->orWhere('due_date', $thisMonth . '21')->orWhere('due_date', $thisMonth . '28')->get(),
        ];

        $toBeScored = [
            'all' => Call::whereNull('scored_at')->WhereNotNull('completed_at'),
            'week' => Call::whereNull('scored_at')->WhereNotNull('completed_at')->where('due_date', $thisWeek)->get(),
            'month' => Call::whereNull('scored_at')->WhereNotNull('completed_at')->where('due_date', $thisMonth . '7')->orWhere('due_date', $thisMonth . '14')->orWhere('due_date', $thisMonth . '21')->orWhere('due_date', $thisMonth . '28')->get(),
        ];

        $data = [
            'calls' => $calls,
            'toBeCompleted' => $toBeCompleted,
            'toBeScored' => $toBeScored,
        ];

        return $data;
    }

    private function roundUpToAny($n, $x=5) {
        return (round($n)%$x === 0) ? round($n) : round(($n+$x/2)/$x)*$x;
    }
}
