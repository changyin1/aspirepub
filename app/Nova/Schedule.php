<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;

class Schedule extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Schedule';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    //public static $title = 'end_date';

    public function title() {
        return $this->client->name . ' - ' .  $this->end_date->format('m/d/Y');
    }

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
        return [
            ID::make()->sortable()->hideFromIndex(),
            NovaBelongsToDepend::make('Client')
                ->options(\App\Client::all()),
            NovaBelongsToDepend::make('QuestionTemplate')
                ->optionsResolve(function ($client) {
                    // Reduce the amount of unnecessary data sent
                    return $client->templates()->get([ 'template_name','id']);
                })->display('template_name')
                ->dependsOn('Client'),
            Number::make('Calls'),
            Select::make('Call Specialist')->options($call_specialists)->displayUsingLabels(),
            Select::make('Coach')->options($coaches)->displayUsingLabels(),
            Text::make('Month', function () {
                if(isset($this->start_date)) {
                    return $this->start_date->format('M Y');
                }
            }),
            DateTime::make('Start Date')->hideFromIndex(),
            DateTime::make('End Date')->hideFromIndex(),
            HasMany::make('Calls'),
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
        return [

        ];
    }
}
