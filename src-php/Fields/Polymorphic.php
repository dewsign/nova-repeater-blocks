<?php

namespace Dewsign\NovaRepeaterBlocks\Fields;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use MichielKempen\NovaPolymorphicField\PolymorphicField;

class Polymorphic extends PolymorphicField
{
    /**
     * Register multiple fields for a Polymorphic relationship
     *
     * @param Request $request
     * @param array $types Array of Nova fields
     * @return self
     */
    public function types(Request $request, array $types)
    {
        foreach ($types as $type) {
            $field = new $type($request);
            $this->type($field->singularLabel(), $type::$model, $field->fields($request));
        }

        return $this;
    }
}
