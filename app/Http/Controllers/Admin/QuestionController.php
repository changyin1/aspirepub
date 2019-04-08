<?php

namespace App\Http\Controllers\Admin;

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
}
