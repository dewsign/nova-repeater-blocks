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
            'viewable' => $this->viewable ?? true,
            'reverse' => false,
        ], $this->meta);
    }

    /**
     * This method has been overloaded to remove the 'reverse' lookup because
     * it causes some strange errors. No time to properly resovle the cause so
     * we are hacking it like this for the moment. Doesn't appear to have caused
     * any side-effects so far. Also removed the parent::jsonSerialize here.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'belongsToId' => $this->belongsToId,
            'belongsToRelationship' => $this->belongsToRelationship,
            'label' => forward_static_call([$this->resourceClass, 'label']),
            'resourceName' => $this->resourceName,
            // 'reverse' => $this->isReverseRelation(app(NovaRequest::class)),
            'searchable' => $this->searchable,
            'singularLabel' => $this->singularLabel,
            'viewable' => $this->viewable,
            'displaysWithTrashed' => $this->displaysWithTrashed,
        ];
    }
}
