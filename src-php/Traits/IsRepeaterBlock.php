<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Illuminate\Http\Request;

trait IsRepeaterBlock
{
    /**
     * Return the name of the view to render this block's content. Can be defined using the static
     * property $repeaterBlockViewTemplate or by overloading this method insid eyour model.
     *
     * @return void
     */
    public static function getBlockViewTemplate()
    {
        return property_exists(get_called_class(), 'repeaterBlockViewTemplate')
            ? static::$repeaterBlockViewTemplate
            : null;
    }
}
