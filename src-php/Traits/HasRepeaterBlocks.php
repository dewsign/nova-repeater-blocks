<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Dewsign\NovaRepeaterBlocks\Models\Repeater;

trait HasRepeaterBlocks
{
    public function repeaters()
    {
        return $this->morphMany(Repeater::class, 'repeatable')
            ->ordered()
            ->with('type');
    }

    public function scopeIncludeRepeaters($query)
    {
        return $query->with('repeaters');
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
