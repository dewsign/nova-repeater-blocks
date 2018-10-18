<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class CustomViewBlock extends Model
{
    use IsRepeaterBlock;

    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::common.customview';
}
