<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\QuestionTemplate;

class QuestionsController extends Controller
{
    public function view_questions($id) {
    	$qt = QuestionTemplate::findorfail($id);
    	$data['template'] = $qt;
    	$data['questions'] = $qt->allQuestions();
    	return view('questions.view_questions', [
            'data' => $data
        ]);
    }

    public function score_questions($id) {
        $qt = QuestionTemplate::findorfail($id);
        $data['template'] = $qt;
        $data['questions'] = $qt->allQuestions();
        return view('questions.score_questions', [
            'data' => $data
        ]);
    }
}
