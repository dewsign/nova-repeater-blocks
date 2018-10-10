<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class ImageBlock extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ImageBlock';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'image';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'image',
        'alt_content',
    ];

    public static function label()
    {
        return __('Image');
    }

    public function fields(Request $request)
    {
        return [
            Image::make('Image')->disk('public'),
            Text::make('Alt Content')->rules('required', 'max:254'),
        ];
    }
}
