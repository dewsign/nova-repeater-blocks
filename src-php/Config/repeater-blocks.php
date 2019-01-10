<?php

return [
    'path' => 'repeaters.custom.',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
    'repeaters' => [
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ImageBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\MarkdownBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ContainerBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock::class,
    ],
];
