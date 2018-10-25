<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
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

    /**
     * The owning repeater of this block type
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function blockOwner()
    {
        return $this->morphMany(Repeater::class, 'type');
    }

    /**
     * Hook into model events in order to update Scout search indexes for the parent objects
     *
     * @return void
     */
    public static function bootIsRepeaterBlock()
    {
        static::updated(function ($model) {
            $model->updateScoutIndexesOnParents();
        });

        static::deleted(function ($model) {
            $model->updateScoutIndexesOnParents();
        });
    }

    /**
     * Attempt to update the owning repeater's search index
     *
     * @return void
     */
    public function updateScoutIndexesOnParents()
    {
        if (!$blockOwner = $this->blockOwner()->first()) {
            return;
        }

        $blockOwner->repeatable->save();
    }
}
