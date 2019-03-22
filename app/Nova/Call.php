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
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;

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
            //BelongsTo::make('Client')->rules('required')->display('name'),
            NovaBelongsToDepend::make('Client')
                ->options(\App\Client::all()),
            NovaBelongsToDepend::make('Schedule')
                ->optionsResolve(function ($client) {
                    // Reduce the amount of unnecessary data sent
                    return $client->schedules()->get(['id']);
                })
                ->dependsOn('Client'),
            Select::make('Call Specialist')->options($call_specialists),
            Select::make('Coach')->options($coaches),
            Text::make('Contact', 'agent_name')->hideFromIndex(),
            //Boolean::make('Scored'),
            Textarea::make('Caller Notes')->hideFromIndex(),
            Textarea::make('Coach Notes')->hideFromIndex(),
            Number::make('Call Score'),
            Text::make('Reservation Confirmation'),
            Text::make('Reservation First Name')->hideFromIndex(),
            Text::make('Reservation Last Name')->hideFromIndex(),
            date::make('Arrival Date', 'arrival_date')->nullable()->hideFromIndex(),
            date::make('Departure Date', 'departure_date')->nullable()->hideFromIndex(),
            Text::make('Cancelation Confirmation'),
            File::make('Call Recording - Not active yet', 'call_recording_id')->disk('public')->hideFromIndex()
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
