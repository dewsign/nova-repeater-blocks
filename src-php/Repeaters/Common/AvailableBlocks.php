<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common;

use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ImageBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\MarkdownBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\CustomViewBlock;

class AvailableBlocks
{
    public static function all()
    {
        return [
            TextBlock::class,
            TextareaBlock::class,
            ImageBlock::class,
            CustomViewBlock::class,
            MarkdownBlock::class,
        ];
    }

    public static function random()
    {
        $all = static::all();
        return $all[array_rand($all)];
    }
}
