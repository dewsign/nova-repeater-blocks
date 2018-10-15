<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\MorphMany;
use Naxon\NovaFieldSortable\Sortable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dewsign\NovaRepeaterBlocks\Fields\Polymorphic;
use Naxon\NovaFieldSortable\Concerns\SortsIndexEntries;
use MichielKempen\NovaPolymorphicField\HasPolymorphicFields;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;

class Repeater extends Resource
{
    use SortsIndexEntries;
    use HasPolymorphicFields;

    public static $defaultSortField = 'repeater_block_order';

    public static $morphTo = [];

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
            $this->morphRepeaters($request),
        ];
    }

    /**
     * What type of repeater blocks should be made available to the resource.
     *
     * @param Request $request
     * @return array
     */
    public function types(Request $request)
    {
        if (!$resourceId = static::getResourceId($request)) {
            return [];
        }

        $type = $this->model()->whereId($resourceId)->first()->type;

        if (method_exists($type, 'types')) {
            return $type::types();
        };

        if (method_exists($type, 'sourceTypes')) {
            return $type::sourceTypes();
        };

        return [];
    }

    /**
     * Allow repeaters on this resource if available
     *
     * @param Request $request
     * @return mixed
     */
    public function morphRepeaters(Request $request)
    {
        if (!$this->repeaterHasSubTypes($request)) {
            return $this->merge([]);
        }

        return $this->merge([
            MorphMany::make(__('Repeaters'), 'repeaters', Repeater::class),
        ]);
    }

    /**
     * Determine if the current repeater has sub-repeater types defined
     *
     * @param Request $request
     * @return boolean
     */
    protected function repeaterHasSubTypes(Request $request)
    {
        if (!$resourceId = $this->getResourceId($request)) {
            return false;
        }

        if (!$model = $this->model()->whereId($resourceId)->first()) {
            return false;
        }

        return method_exists($model->type, 'types');
    }

    /**
     * Get the resource ID of the current repeater item
     *
     * @param Request $request
     * @return mixed
     */
    protected function getResourceId(Request $request)
    {
        if ($resourceId = $request->get('viaResourceId')) {
            return $resourceId;
        };

        parse_str(parse_url($request->server->get('HTTP_REFERER'), PHP_URL_QUERY), $params);

        if ($resourceId = array_get($params, 'viaResourceId')) {
            return $resourceId;
        };

        if ($resourceId = $request->route('resourceId')) {
            return $resourceId;
        };

        return null;
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
