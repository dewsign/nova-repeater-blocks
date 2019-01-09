<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\ContainerBlock;

trait CanBeContainerised
{
    public static function sourceTypes()
    {
        return ContainerBlock::types();
    }
}
