<?php

namespace App\Http\Controllers;

use App\Recording;
use App\Score;
use Illuminate\Http\Request;
use \App\QuestionTemplate;
use App\Call;
use Carbon\Carbon;
use App\ScheduleAttachment;

class QuestionsController extends Controller
{
    public function viewQuestions($id) {
        $call = Call::where('id', $id)->with('schedule')->first();
        $template_id = $call->schedule->questionstemplates_id;
    	$qt = QuestionTemplate::findorfail($template_id);
        $attachments = ScheduleAttachment::where('schedule_id', $call->schedule->id)->get();

    	$data = [
    	    'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions(),
            'attachments' => $attachments,
        ];

    	return view('questions.view_questions', [
            'data' => $data
        ]);
    }

    public function scoreQuestionsView($id) {
        $call = Call::where('id', $id)->with('schedule')->first();
        $recordings = Recording::where('call_id', $id)->get();
        $links = [];
        if (!$recordings->isEmpty()) {
            foreach ($recordings as $recording) {
                if ($recording->path == 'link') {
                    $links[] = $recording->filename;
                } else {
                    $links[] = $recording->path . $recording->filename;
                }
            }
        }
        $template_id = $call->schedule->questionstemplates_id;
        $qt = QuestionTemplate::findorfail($template_id);

        $data = [
            'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions(),
            'scores' => $call->scores(),
            'recordings' => $links
        ];

        return view('questions.score_questions', [
            'data' => $data
        ]);
    }

    public function scoreQuestions(Request $request) {
        $call = Call::findorfail($request->callId);
        $scores = $request->score;
        $now = Carbon::now();
        $call->scored_at = $now;
        $call->save();

        if ($request->note) {
            $call->coach_notes = $request->note;
            $call->save();
        }

        if ($request->engagement) {
            $call->call_score = $request->engagement;
            $call->save();
        }

        if ($request->agent) {
            $call->agent_name = $request->agent;
            $call->save();
        }

        foreach ($scores as $question => $score) {
            if (isset($score)) {
                $checkScore = Score::where([
                    'call_id' => $call->id,
                    'question_id' => $question
                ])->first();
                if ($checkScore) {
                    $checkScore->score = $score;
                    $checkScore->save();
                } else {
                    $newScore = new Score;
                    $newScore->call_id = $call->id;
                    $newScore->question_id = $question;
                    $newScore->score = $score;
                    $newScore->save();
                }
            }
        }

        $template_id = $call->schedule->questionstemplates_id;
        $qt = QuestionTemplate::findorfail($template_id);

        $recordings = Recording::where('call_id', $call->id)->get();
        $links = [];
        if (!$recordings->isEmpty()) {
            foreach ($recordings as $recording) {
                if ($recording->path == 'link') {
                    $links[] = $recording->filename;
                } else {
                    $links[] = $recording->path . $recording->filename;
                }
            }
        }
        if ($recording) {
            if ($recording->path == 'link') {
                $link = $recording->filename;
            } else {
                $link = $recording->path . $recording->filename;
            }
        }

        $data = [
            'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions(),
            'scores' => $call->scores(),
            'recordings' => $links
        ];

        return view('questions.score_questions', [
            'data' => $data
        ]);
    }
}
