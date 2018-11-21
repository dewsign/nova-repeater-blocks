<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class CustomViewBlock extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock';

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
        'id',
        'template_name',
    ];

    public static function label()
    {
        return __('Custom View');
    }

    public function fields(Request $request)
    {
        $options = Repeater::customTemplates();

        return [
            Select::make('Template Name')
                ->options($options)
                ->displayUsingLabels()
                ->hideFromIndex(),
        ];
    }
}
