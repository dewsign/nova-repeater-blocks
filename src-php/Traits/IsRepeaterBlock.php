<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Log;
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

    public function repeater()
    {
        return $this->hasOne('Dewsign\NovaRepeaterBlocks\Models\Repeater', 'type_id');
    }

    public static function bootIsRepeaterBlock()
    {
        static::updated(function ($model) {
            Log::info('Updating');

            if (!$model->repeater) {
                Log::info('no repeater');

                return;
            }

            $model->repeater->repeatable->save();

            Log::info('done');
        });

        static::saving(function ($model) {
            Log::info('saving');

            if (!$model->repeater) {
                Log::info('no repeater');
                return;
            }

            $model->repeater->repeatable->save();
            
            Log::info('done');
        });


        static::pivotAttaching(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            Log::info('pivotAttaching');
        });
        
        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            Log::info('pivotAttached');
        });
        
        static::pivotDetaching(function ($model, $relationName, $pivotIds) {
            Log::info('pivotDetaching');
        });

        static::pivotDetached(function ($model, $relationName, $pivotIds) {
            Log::info('pivotDetached');
        });
        
        static::pivotUpdating(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            Log::info('pivotUpdating');
        });
        
        static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            Log::info('pivotUpdated');
        });
    }
}
