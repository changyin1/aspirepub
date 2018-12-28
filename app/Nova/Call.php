<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;

class Call extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Call';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'client',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function fields(Request $request)
    {
        $call_specialists = \App\User::whereIn('role', ['coach','call_specialist'])->pluck('name', 'id');
        $coaches = \App\User::where('role', 'coach')->pluck('name', 'id');
        //$schedules = \App\Schedule::where('client_id', 'coach')->pluck('name', 'id');

        return [
            ID::make()->sortable()->hideFromIndex(),            
            BelongsTo::make('Client')->rules('required')->display('name'),
            BelongsTo::make('Schedule', 'schedule', 'App\Nova\Schedule')->nullable(),
            Select::make('Call Specialist')->options($call_specialists),
            Select::make('Coach')->options($coaches),
            //Boolean::make('Scored'),
            Textarea::make('Caller Notes'),
            Textarea::make('Coach Notes'),
            Number::make('Call Score'),
            File::make('Call Recording - Not active yet', 'call_recording_id')->disk('public')
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
