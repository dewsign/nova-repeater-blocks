<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common;

use Dewsign\NovaRepeaterBlocks\Traits\ResourceCanBeContainerised;

class AvailableBlocks
{
    /**
     * Return all available blocks
     *
     * @return array
     */
    public static function all()
    {
        return config('repeater-blocks.repeaters');
    }

    /**
     * Return the blocks which can be included in containers
     *
     * @return array
     */
    public static function containable()
    {
        return collect(config('repeater-blocks.repeaters'))
            ->filter(function ($block) {
                return in_array(ResourceCanBeContainerised::class, class_uses($block));
            })->toArray();
    }

    public static function random()
    {
        $all = static::all();
        return $all[array_rand($all)];
    }
}
