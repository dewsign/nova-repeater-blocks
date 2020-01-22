<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\MorphMany;
use Dewsign\NovaFieldSortable\Sortable;
use Dewsign\NovaFieldSortable\IsSorted;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dewsign\NovaRepeaterBlocks\Models\Repeater as BaseRepeater;
use Dewsign\NovaRepeaterBlocks\Fields\Polymorphic;
use MichielKempen\NovaPolymorphicField\HasPolymorphicFields;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;

class Repeater extends Resource
{
    use IsSorted;
    use HasPolymorphicFields;

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

    public static $perPageViaRelationship = 100;

    /**
     * The number of results to display in the global search.
     *
     * @var int
     */
    public static $globalSearchResults = 50;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Display the parent relationships leading to this repeater in search results.
     *
     * @return string
     */
    public function subtitle()
    {
        return self::getParentRepeaterName($this);
    }

    /**
     * Recursively build the chain of parent relations.
     *
     * @param $repeater
     * @return string
     */
    public static function getParentRepeaterName($repeater)
    {
        if (!$repeater->repeatable) {
            return null;
        }

        $parentName = self::getParentRepeaterName($repeater->repeatable);

        return "{$parentName} > {$repeater->repeatable->name}";
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Repeaters');
    }

    public static function morphTo()
    {
        return [];
    }

    public static function getMorphToArray()
    {
        return array_merge(static::$morphTo, Arr::wrap(static::morphTo()));
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return array_merge([
            Sortable::make('Sort', 'id'),
            MorphTo::make('Repeatable')->types(Arr::wrap(static::getMorphToArray()))->onlyOnDetail(),
            Text::make('Name'),
            Polymorphic::make('Type')->types($request, $this->types($request))->hideTypeWhenUpdating(),
            $this->morphRepeaters($request),
        ], $this->extraInfo($request));
    }

    public function extraInfo(Request $request)
    {
        $infoValue = '';

        if (method_exists($this->type, 'getExtraInfo')) {
            $infoValue = $this->type->getExtraInfo();
        }

        return Arr::wrap(Text::make(__('Extra Info'), function () use ($infoValue) {
            return BaseRepeater::getPrettyFilename($infoValue);
        })->onlyOnIndex());
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

        $type = optional($this->model()->whereId($resourceId)->first())->type;

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

        if ($resourceId = Arr::get($params, 'viaResourceId')) {
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
