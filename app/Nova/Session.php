<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;

class Session extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Session';

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
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),            
            BelongsTo::make('Schedule', 'schedule', 'App\Nova\Schedule')->nullable(),
            BelongsTo::make('Client')->rules('required')->display('name'),
            BelongsTo::make('Coach', 'coach', 'App\Nova\Coach')->nullable(),
            BelongsTo::make('Scribe', 'scribe', 'App\Nova\Scribe')->nullable(),
            //BelongsTo::make('Coach')->nullable(),
            //Text::make('Coach', function () { return $this->coach->user->name;}),
            /*
            Text::make('Scribe', function () { 
                if(isset($this->scribe->user->name)) {
                    return $this->scribe->user->name;    
                } else {
                    return NULL;
                }
                
            }),
            */
            //Boolean::make('Scored'),
            Textarea::make('Notes'),
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
