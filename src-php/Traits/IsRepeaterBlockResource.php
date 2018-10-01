<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Illuminate\Http\Request;

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
}
