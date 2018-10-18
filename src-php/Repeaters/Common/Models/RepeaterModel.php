<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class RepeaterModel extends Model
{
    use IsRepeaterBlock;
    use PivotEventTrait;

    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::common.text';
}
