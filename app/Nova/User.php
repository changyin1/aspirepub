<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Silvanite\NovaFieldCheckboxes\Checkboxes;
use Laravel\Nova\Fields\Select;
use Nova\Multiselect\Multiselect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'email', 'status', 'languages', 'role'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $clients_mappings = \App\Client::where('id', '!=', $this->id)->pluck('name', 'id');
        $current_url = URL::current();
        Log::alert($current_url);
        $segments = explode('/', $current_url);        
        $action = $segments[count($segments)-1];
        Log::alert($action);
        if($action == 'edit' || is_numeric($action)) {
            if(is_numeric($action)) {
                $current_id = $segments[count($segments)-1];
            } else {
                $current_id = $segments[count($segments)-2];    
            }
            
            Log::alert($current_id);
            $current_user = \App\User::find($current_id);
            $selectedOptions = json_decode($current_user->client_ids);
        } else {
            $selectedOptions = array();
        }
        return [
            ID::make()->sortable()->hideFromIndex(),

            Gravatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'max:255'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            Select::make('Role')->options([
                'admin' => 'Admin',
                'call_specialist' => 'Call Specialist',
                'client' => 'Client',
                'coach' => 'Coach',                
            ]),

            Checkboxes::make('Languages')->options([
                'arabic' => 'Arabic',
                'french' => 'French',
                'italian' => 'Italian',                
                'mandarin' => 'Mandarin',
                'portuguese' => 'Portuguese',
                'russian' => 'Russian',
                'spanish' => 'Spanish',
            ])->hideFromIndex(),

            Multiselect::make('Properties', 'client_ids')->options($clients_mappings,$selectedOptions),
            
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
