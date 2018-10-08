<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common;

use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextareaBlock;

class AvailableBlocks
{
    public static function all()
    {
        return [
            TextBlock::class,
            TextareaBlock::class,
        ];
    }

    public static function random()
    {
        $all = static::all();
        return $all[array_rand($all)];
    }
}
