<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index() {
        $questions = Question::all();
        $data = [
            'questions' => $questions
        ];
        return view('admin.questions', [
            'data' => $data
        ]);
    }

    public function create(NewQuestionRequest $request) {
        $question = new Question;
        $question->question = $request->question;
        $question->type = $request->type;
        $question->weight = $request->weight;
        $question->active = true;

        $question->save();
        return response()->json(['success' => true]);
    }
}
