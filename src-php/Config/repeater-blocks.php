<?php

return [
    'path' => 'repeaters.custom.',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
    'repeaters' => [
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\ImageBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\MarkdownBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextareaBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\ContainerBlock::class,
        Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\CustomViewBlock::class,
    ],
];
