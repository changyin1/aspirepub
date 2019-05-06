<?php

namespace App\Http\Controllers;

use App\Recording;
use App\Score;
use Illuminate\Http\Request;
use \App\QuestionTemplate;
use App\Call;

class QuestionsController extends Controller
{
    public function viewQuestions($id) {
        $call = Call::where('id', $id)->with('schedule')->first();
        $template_id = $call->schedule->questionstemplates_id;
    	$qt = QuestionTemplate::findorfail($template_id);

    	$data = [
    	    'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions()
        ];

    	return view('questions.view_questions', [
            'data' => $data
        ]);
    }

    public function scoreQuestionsView($id) {
        $call = Call::where('id', $id)->with('schedule')->first();
        $recording = Recording::where('call_id', $id)->first();
        $link = '';
        if ($recording) {
            if ($recording->path == 'link') {
                $link = $recording->filename;
            } else {
                $link = $recording->path . $recording->filename;
            }
        }
        $template_id = $call->schedule->questionstemplates_id;
        $qt = QuestionTemplate::findorfail($template_id);

        $data = [
            'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions(),
            'scores' => $call->scores(),
            'recording' => $link
        ];

        return view('questions.score_questions', [
            'data' => $data
        ]);
    }

    public function scoreQuestions(Request $request) {
        $call = Call::findorfail($request->callId);
        $scores = $request->post();
        unset($scores['_token']);
        unset($scores['callId']);

        foreach ($scores as $question => $score) {
            if (!is_null($score)) {
                $newScore = new Score;
                $newScore->call_id = $call->id;
                $newScore->question_id = $question;
                $newScore->score = $score;
                $score->save();
            }
        }

        $template_id = $call->schedule->questionstemplates_id;
        $qt = QuestionTemplate::findorfail($template_id);

        $data = [
            'call' => $call,
            'template' => $qt,
            'questions' => $qt->allQuestions(),
            'scores' => $call->scores()
        ];

        return view('questions.score_questions', [
            'data' => $data
        ]);
    }
}
