<?php

namespace Dewsign\NovaRepeaterBlocks\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Repeater extends Model implements Sortable
{
    use SortableTrait;
    use HasRepeaterBlocks;

    public $sortable = [
        'order_column_name' => 'repeater_block_order',
        'sort_when_creating' => true,
    ];

    /**
     * When nesting repeaters, this references the parent repeater
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function repeatable()
    {
        return $this->morphTo();
    }

    /**
     * Links to the Block Type for this repeater item
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function type()
    {
        return $this->morphTo();
    }

    /**
     * Hook into model boot events to ensure scout search indexes are updated
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            optional($model->type)->delete();
        });

        static::saved(function ($model) {
            optional($model->repeatable)->searchable();
        });

        static::deleted(function ($model) {
            optional($model->repeatable)->searchable();
        });
    }
}
