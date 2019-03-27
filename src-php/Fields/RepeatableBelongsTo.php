<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use \Laravel\Nova\Fields\BelongsTo;

class RepeatableBelongsTo extends BelongsTo
{
    /**
     * A custom version of the standard response excluding the check for the `reverse` relationship
     * as this is causing errors when including BelongsTo relationships in nested repeaters.
     *
     * @return array
     */
    public function meta()
    {
        return array_merge([
            'resourceName' => $this->resourceName,
            'label' => forward_static_call([$this->resourceClass, 'label']),
            'singularLabel' => $this->singularLabel
                ?? $this->name
                ?? forward_static_call([$this->resourceClass, 'singularLabel']),
            'belongsToRelationship' => $this->belongsToRelationship,
            'belongsToId' => $this->belongsToId,
            'searchable' => $this->searchable,
            'viewable' => $this->viewable,
            'reverse' => false,
        ], $this->meta);
    }
}
