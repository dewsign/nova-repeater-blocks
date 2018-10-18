<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Illuminate\Http\Request;
use Log;

trait IsRepeaterBlockResource
{
    /**
     * Do not show this resource in the Navigation as it is intended for a Polymorphic relationship
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    }

    public static function bootIsRepeaterBlockResource()
    {
        Log::info('booting block1');

        static::updated(function ($model) {
            Log::info('updating block1');
            Log::info(get_class($model));
        });
    }
}
