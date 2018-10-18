<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\RepeaterModel;

class CustomViewBlock extends RepeaterModel
{
    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::common.customview';
}
