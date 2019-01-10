<?php

return [
    'path' => 'repeaters.custom.',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
        'processors' => [
            'default' => Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor::class,
            'photograph' => Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor::class,
            'person' => Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor::class,
            'people' => Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor::class,
            'logo' => Dewsign\NovaRepeaterBlocks\Processors\ImageProcessor::class,
        ],
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
