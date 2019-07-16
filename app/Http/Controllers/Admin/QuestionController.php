<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Company;
use App\Http\Requests\EditQuestionRequest;
use App\Http\Requests\NewQuestionRequest;
use App\Question;
use App\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TemplateQuestion;

class QuestionController extends Controller
{
    public function index() {
        $questions = Question::all();
        $clients = Client::all();
        $companies = Company::all();
        $regions = Region::all();
        $data = [
            'questions' => $questions,
            'clients' => $clients,
            'companies' => $companies,
            'regions' => $regions
        ];
        return view('admin.questions', [
            'data' => $data
        ]);
    }

    public function create(NewQuestionRequest $request) {
        $question = new Question;
        if ($request->client) {
            $client = Client::where('id', $request->client)->first();
            if (!$client) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'client' => ['That client does not exist.'],
                ]);
                throw $error;
            }
        }
        if ($request->company) {
            $company = Company::where('id', $request->company)->first();
            if (!$company) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'company' => ['That company does not exist.'],
                ]);
                throw $error;
            }
        }
        if ($request->region) {
            $region = Region::where('id', $request->region)->first();
            if (!$region) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'region' => ['That region does not exist.'],
                ]);
                throw $error;
            }
        }
        $question->question = $request->question;
        $question->type = $request->type;
        $question->weight = $request->weight;
        $question->client = $request->client;
        $question->company = $request->company;
        $question->region = $request->region;
        $question->active = true;

        $question->save();
        return response()->json(['success' => true]);
    }

    public function show($id, Question $question) {
        $question = $question->where('id', $id)->first();
        $templates = $question->templates();
        $clients = Client::all();
        $companies = Company::all();
        $regions = Region::all();

        $data = [
            'question' => $question,
            'templates' => $templates,
            'clients' => $clients,
            'companies' => $companies,
            'regions' => $regions,
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

        $question->client = null;
        $question->company = null;
        $question->region = null;

        if ($request->client && $request->client != 0) {
            $client = Client::where('id', $request->client)->first();
            if (!$client) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'client' => ['That client does not exist.'],
                ]);
                throw $error;
            }
            $question->client = $request->client;
        }
        if ($request->company && $request->company != 0) {
            $company = Company::where('id', $request->company)->first();
            if (!$company) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'company' => ['That company does not exist.'],
                ]);
                throw $error;
            }
            $question->company = $request->company;
        }
        if ($request->region && $request->region != 0) {
            $region = Region::where('id', $request->region)->first();
            if (!$region) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'region' => ['That region does not exist.'],
                ]);
                throw $error;
            }
            $question->region = $request->region;
        }

        $templates = $question->templates();

        if ($question->question != $request->question || $question->type = $request->type || $question->weight = $request->weight) {

            $updateQuestion = new Question();
            $updateQuestion->question = $request->question;
            $updateQuestion->type = $request->type;
            $updateQuestion->weight = $request->weight;
            $updateQuestion->client = $request->client;
            $updateQuestion->company = $request->company;
            $updateQuestion->region = $request->region;
            $updateQuestion->previous_question = $question->id;

            $updateQuestion->save();

            $question->active = false;

            $templateQuestions = TemplateQuestion::where('question_id', $question->id)->get();
            foreach($templateQuestions as $templateQuestion) {
                $templateQuestion->active = false;
                $templateQuestion->save();

                $newTemplateQuestion = new TemplateQuestion;
                $newTemplateQuestion->template_id = $templateQuestion->template_id;
                $newTemplateQuestion->question_id = $updateQuestion->id;
                $newTemplateQuestion->active = true;
                $newTemplateQuestion->order = $templateQuestion->order;

                $newTemplateQuestion->save();
            };
        }

        $question->save();

        $clients = Client::all();
        $companies = Company::all();
        $regions = Region::all();

        $data = [
            'question' => $updateQuestion,
            'templates' => $templates,
            'clients' => $clients,
            'companies' => $companies,
            'regions' => $regions,
            'save' => true
        ];
        return view('admin.questions.edit', [
            'data' => $data
        ]);

    }
}
