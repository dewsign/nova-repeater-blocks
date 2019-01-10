<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Dewsign\NovaRepeaterBlocks\Traits\ResourceCanBeContainerised;

class ContainerBlock extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;
    use ResourceCanBeContainerised;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ContainerBlock';

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
        'template',
    ];

    public static function label()
    {
        return __('Containers');
    }

    public function fields(Request $request)
    {
        $packageTemplates = Repeater::customTemplates(__DIR__ . '/../../../Resources/views/container');
        $appTemplates = Repeater::customTemplates(resource_path('views/vendor/nova-repeater-blocks/container'));

        return [
            Select::make('Template')
                ->options(array_merge($packageTemplates, $appTemplates))
                ->displayUsingLabels()
                ->hideFromIndex(),
        ];
    }
}
