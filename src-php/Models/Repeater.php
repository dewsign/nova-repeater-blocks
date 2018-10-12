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

    public function repeatable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            optional($model->type)->delete();
        });
    }
}
