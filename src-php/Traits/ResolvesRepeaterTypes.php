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

    /**
     * Make a desired model accessible from a repeater without knowing its name or type.
     *
     * @return mixed
     */
    public function getModelAttribute()
    {
        if (!method_exists($this->type, 'resolveModel')) {
            return null;
        }

        return $this->type->resolveModel($this);
    }
}
