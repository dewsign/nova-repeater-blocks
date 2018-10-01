<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Dewsign\NovaRepeaterBlocks\Models\Repeater;

trait HasRepeaterBlocks
{
    public function repeaters()
    {
        return $this->morphMany(Repeater::class, 'repeatable')->ordered();
    }

    public static function bootHasRepeaterBlocks()
    {
        static::deleting(function ($model) {
            $model->repeaters()->each(function ($repeater) {
                if (!$repeater) {
                    return;
                }

                $repeater->delete();
            });
        });
    }
}
