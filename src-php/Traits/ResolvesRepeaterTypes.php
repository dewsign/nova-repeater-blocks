<?php

namespace Dewsign\NovaRepeaterBlocks\Traits;

/**
 * This trait enabled repeaters to share commonly used attributes
 * across any polymorphic relation without knowing it's type.
 *
 * The associated target methods need to be implemented on the related model.
 */
trait ResolvesRepeaterTypes
{
    /**
     * Return the target URL from the relation to link to.
     *
     * @return String
     */
    public function getActionAttribute()
    {
        if (!method_exists($this->type, 'resolveAction')) {
            return null;
        }

        return $this->type->resolveAction();
    }

    /**
     * Return the label to use when displaying this resource
     *
     * @return String
     */
    public function getLabelAttribute()
    {
        if (!method_exists($this->type, 'resolveLabel')) {
            return $this->title;
        }

        return $this->type->resolveLabel($this);
    }

    /**
     * This view will be rendered when using the @repeaterblocks helper in your views.
     * NOTE: Use {!! $item->view !!} when accessing this manually
     *
     * @return String
     */
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
