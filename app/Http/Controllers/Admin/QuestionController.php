<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditQuestionRequest;
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

    public function show($id, Question $question) {
        $question = $question->where('id', $id)->first();
        $templates = $question->templates();

        $data = [
            'question' => $question,
            'templates' => $templates,
            'save' => false
        ];

        return view('admin.questions.edit', [
            'data' => $data
        ]);

    }

    public function edit(EditQuestionRequest $request) {
        $question = Question::where('id', $request->id)->first();
        if (!$question) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'question' => ['That question does not exist.'],
            ]);
            throw $error;
        }

        $question->question = $request->question;
        $question->type = $request->type;
        $question->weight = $request->weight;

        $question->save();

        $templates = $question->templates();

        $data = [
            'question' => $question,
            'templates' => $templates,
            'save' => true
        ];
        return view('admin.questions.edit', [
            'data' => $data
        ]);

    }
}
