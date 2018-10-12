<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Textarea;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class MarkdownBlock extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\MarkdownBlock';

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
        'content',
    ];

    public static function label()
    {
        return __('Markdown');
    }

    public function fields(Request $request)
    {
        return [
            Markdown::make('Content')->rules('required'),
        ];
    }
}
