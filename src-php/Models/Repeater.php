<?php

namespace Dewsign\NovaRepeaterBlocks\Models;

use Illuminate\Support\Facades\File;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\ResolvesRepeaterTypes;

class Repeater extends Model implements Sortable
{
    use SortableTrait;
    use HasRepeaterBlocks;
    use ResolvesRepeaterTypes;

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
            optional($model->repeatable)->save();
        });

        static::deleted(function ($model) {
            optional($model->repeatable)->save();
        });
    }

    public static function customTemplates($path = null)
    {
        $templatePath = $path ?? static::getTemplatePath();
        $templates = File::exists($templatePath) ? File::files($templatePath) : null;

        return collect($templates)->mapWithKeys(function ($file) {
            $filename = $file->getFilename();

            return [
                str_replace('.blade.php', '', $filename) => static::getPrettyFilename($filename),
            ];
        })->all();
    }

    private static function getTemplatePath()
    {
        $path = str_replace('.', '/', config('repeater-blocks.path'));

        return resource_path('views/' . $path);
    }

    private static function getPrettyFilename($filename)
    {
        $basename = str_replace('.blade.php', '', $filename);

        return title_case(str_replace('-', ' ', $basename));
    }
}
