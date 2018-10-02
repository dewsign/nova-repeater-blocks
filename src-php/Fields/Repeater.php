<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\MorphTo;
use Naxon\NovaFieldSortable\Sortable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dewsign\NovaRepeaterBlocks\Fields\Polymorphic;
use Naxon\NovaFieldSortable\Concerns\SortsIndexEntries;
use MichielKempen\NovaPolymorphicField\HasPolymorphicFields;

class Repeater extends Resource
{
    use SortsIndexEntries;
    use HasPolymorphicFields;

    public static $defaultSortField = 'repeater_block_order';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaRepeaterBlocks\Models\Repeater';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Repeaters');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            MorphTo::make('Repeatable')->types(array_wrap(static::$morphTo))->onlyOnDetail(),
            Text::make('Name'),
            Polymorphic::make('Type')->types($request, $this->types($request))->hideTypeWhenUpdating(),
            Sortable::make('Order', 'id'),
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
