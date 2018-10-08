<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class TextBlock extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;

    public static $model = 'Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock';

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
        'format',
    ];

    public static function label()
    {
        return __('Text');
    }

    public function fields(Request $request)
    {
        return [
            Select::make('Format')
                ->options([
                    'p' => 'Paragraph',
                    'h2' => 'Heading',
                    'h3' => 'Subheading',
                ])
                ->rules('required', 'max:254')
                ->displayUsingLabels(),

            NovaDependencyContainer::make([
                Text::make('Content')->rules('required', 'max:254'),
            ])->dependsOnNotEmpty('format'),
        ];
    }
}
