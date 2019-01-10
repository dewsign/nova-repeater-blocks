<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;
use Dewsign\NovaRepeaterBlocks\Traits\CanBeContainerised;

class ImageBlock extends Model
{
    use IsRepeaterBlock;
    use CanBeContainerised;

    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::common.image';

    public $append = [
        'default_image',
    ];

    public function getDefaultImageAttribute()
    {
        return $this->getImage();
    }

    public function getImage(array $params = [])
    {
        return config(
            "repeater-blocks.images.processors.{$this->style}",
            config("repeater-blocks.images.processors.default")
        )::get($this->image, $params);
    }
}
