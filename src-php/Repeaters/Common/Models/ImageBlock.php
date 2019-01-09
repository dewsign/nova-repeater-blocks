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
}
