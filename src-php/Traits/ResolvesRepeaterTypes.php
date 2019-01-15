<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

trait ResolvesRepeaterTypes
{
    public function getActionAttribute()
    {
        if (!method_exists($this->type, 'resolveAction')) {
            return null;
        }

        return $this->type->resolveAction();
    }

    public function getLabelAttribute()
    {
        if (!method_exists($this->type, 'resolveLabel')) {
            return $this->title;
        }

        return $this->type->resolveLabel($this);
    }

    public function getViewAttribute()
    {
        if (!method_exists($this->type, 'resolveView')) {
            return null;
        }

        return $this->type->resolveView($this);
    }
}
