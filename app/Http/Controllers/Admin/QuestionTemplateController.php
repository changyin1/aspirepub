<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewQuestionTemplateRequest;
use App\Question;
use App\QuestionTemplate;
use App\Schedule;
use App\TemplateQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionTemplateController extends Controller
{
    public function index() {
        $templates = QuestionTemplate::all();
        $data = [
            'templates' => $templates
        ];
        return view('admin.question_templates', [
            'data' => $data
        ]);
    }

    public function template($id) {
        $template = QuestionTemplate::where('id', $id)->first();
        $questions = Question::where('active', true);
        foreach($template->questions as $question) {
            $questions->where('id', '!=', $question->question->id);
        }

        //check if template already in use
        $edit = $template->used();

        $data = [
            'template' => $template,
            'questions' => $questions,
            'edit' => $edit
        ];
        return view('admin.question_templates.edit', [
            'data' => $data
        ]);
    }

    public function updateOrder(Request $request) {
        $request = $request->all();

        foreach($request as $id => $order) {
            TemplateQuestion::where('id', $id)
                ->update(['order' => $order]);
        }

        $templateQuestions = TemplateQuestion::all();

        return response()->json(['success' => true, 'templateQuestions' => $templateQuestions]);
    }

    public function create(NewQuestionTemplateRequest $request) {
        $template = new QuestionTemplate;
        $template->template_name = $request->name;
        $template->client_id = 0;

        $template->save();
        return response()->json(['success' => true]);
    }

    public function addQuestionToTemplate (Request $request) {
        $request->validate([
            'template_id' => 'required',
            'question' => 'required'
        ]);

        $template = QuestionTemplate::where('id', $request->template_id)->first();
        if (!$template) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'template_id' => ['Invalid template.'],
            ]);
            throw $error;
        }

        $question = Question::where('id', $request->question)->first();
        if (!$question) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'question' => ['That question does not exist.'],
            ]);
            throw $error;
        }

        foreach($template->questions as $question) {
            if ($question->question->id == $request->question) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'question' => ['That question has already been added to this question template.'],
                ]);
                throw $error;
            }
        }

        $templateQuestion = new TemplateQuestion;
        $templateQuestion->template_id = $request->template_id;
        $templateQuestion->question_id = $request->question;
        $templateQuestion->active = true;
        $templateQuestion->order = $template->questionCount() + 1;

        $templateQuestion->save();
        return response()->json(['success' => true]);
    }
}
