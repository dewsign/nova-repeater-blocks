<?php

namespace Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\CanBeContainerised;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\AvailableBlocks;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\MarkdownBlock;

class ContainerBlock extends Model
{
    use IsRepeaterBlock;
    use HasRepeaterBlocks;
    use CanBeContainerised;

    public static $repeaterBlockViewTemplate = 'nova-repeater-blocks::container.default';

    public static function types()
    {
        return AvailableBlocks::containable();
    }
}
