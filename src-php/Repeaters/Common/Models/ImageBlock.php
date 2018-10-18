<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\RepeaterModel;
use Illuminate\Database\Eloquent\Model;

class ImageBlock extends RepeaterModel
{
    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::common.image';
}
