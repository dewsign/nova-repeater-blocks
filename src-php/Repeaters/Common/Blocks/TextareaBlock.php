<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Textarea;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Dewsign\NovaRepeaterBlocks\Traits\ResourceCanBeContainerised;

class TextareaBlock extends Resource
{
    use IsRepeaterBlockResource;
    use ResourceCanBeContainerised;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock';

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
        'name',
        'content',
    ];

    public static function label()
    {
        return __('Text Areas');
    }

    public function fields(Request $request)
    {
        return [
            Textarea::make('Content')->rules('nullable'),
        ];
    }
}
