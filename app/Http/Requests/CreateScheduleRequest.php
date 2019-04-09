<?php

namespace App\Http\Requests;

use App\Client;
use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $clients = Client::all();
        $clientIds = [];
        foreach ($clients as $client) {
            $clientIds[] = $client->id;
        }
        return [
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
            'client' => 'required|in:' . implode(',', $clientIds),
            'calls' => 'required|Min:1'
        ];
    }
}
