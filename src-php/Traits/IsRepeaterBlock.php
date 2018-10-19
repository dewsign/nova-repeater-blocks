<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Dewsign\NovaRepeaterBlocks\Events\RepeaterSaved;

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

    public function repeater()
    {
        return $this->hasOne('Dewsign\NovaRepeaterBlocks\Models\Repeater', 'type_id');
    }

    public static function bootIsRepeaterBlock()
    {
        static::saved(function ($model) {
            Event::fire(new RepeaterSaved($model));
        });
    }
}
