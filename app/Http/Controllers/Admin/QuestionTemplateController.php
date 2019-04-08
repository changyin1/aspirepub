<?php

namespace App\Http\Controllers\Admin;

use App\QuestionTemplate;
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
        $data = [
            'template' => $template
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
}
